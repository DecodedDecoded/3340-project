<!-- Class file for comments -->
<?php
// includes 
require "BtnVendor.php";
require "CommentOptions.php";

// class
class Comment {

    // private variables - db connection, data from db table, current user, media ID
    private $sqlcon;
    private $table_data;
    private $logged_in_user;
    private $mediaId;

    // construct
    public function __construct($sqlcon, $comment, $logged_in_user, $mediaId) {
        // update private vars - get db connection, current user, and ID of media user is viewing
        $this->sqlcon = $sqlcon;
        $this->logged_in_user = $logged_in_user;
        $this->mediaId = $mediaId;

        // store array of comments associated with the media in table_data
        if(!is_array($comment)) {
            $sql_statement = "SELECT * FROM comments where id=$comment";
            $sql_qry = $this->sqlcon->query($sql_statement);
            $this->table_data = $sql_qry->fetch_assoc();
        }
    }

    // function to create comment
    public function addComment() {
        // get comment information
        $comment = $this->table_data["id"];// comment ID
        $mediaId = $this->getMediaId();// media ID
        $body = $this->table_data["body"];// comment text
        $commentator = $this->table_data["postedBy"];// user who posted comment
        $profileButton = BtnVendor::createProfileBtn($this->sqlcon, $commentator);// embedded button to poster's profile page
        $time_elapsed = $this->comment_date($this->table_data["datePosted"]);

        // generate comment controls: Reply, Like, Dislike
        $controls_object = new CommentOptions($this->sqlcon, $this, $this->logged_in_user);
        $controls = $controls_object->create();

        // get responses to comment
        $numResponses = $this->getNumResponses();// number of replies
        
        // html for responses
        if($numResponses > 0) {
            $viewResponses = "<span class='repliesSection viewReplies' onclick='getResponses($comment, this, $mediaId)'>
                                    View $numResponses responses</span>";
        }
        else {
            $viewResponses = "<div class='repliesSection'></div>";
        }

        // html for comment container
        return "<div class='item_container'>
                    <div class='comment'>
                        $profileButton

                        <div class='main_container'>

                            <div class='comment_header'>
                                <a href='profile.php?username=$commentator'>
                                    <span class='username'>$commentator</span>
                                </a>
                                <span class='timestamp'>$time_elapsed</span>
                            </div>

                            <div class='body'>
                                $body
                            </div>
                        </div>

                    </div>

                    $controls
                    $viewResponses
                </div>";
    }

    // get methods

    // get number of replies to comment
    public function getNumResponses() {
        // use comment ID to get number of responses to comment
        $comment = $this->table_data["id"];
        $sql_statement = "SELECT count(*) FROM comments WHERE responseTo=$comment";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return number of responses
        return $sql_qry->fetch_assoc();
    }

    // get date of comment
    function comment_date($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    // comment ID
    public function getId() {
        return $this->table_data["id"];
    }

    // media ID
    public function getMediaId() {
        return $this->mediaId;
    }

    // check if given user has liked comment
    public function LikedByUser() {
        // get comment ID and user who liked comment
        $comment = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // retrieve like if user liked comment
        $sql_statement = "SELECT * FROM likes WHERE username=$username AND commentId=$comment";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return truth value on whether given user liked the comment
        if ($sql_qry->num_rows > 0) {
            return true;
        }
        else {
            return false;
        };
    }

    // check if given user has disliked comment
    public function DislikedByUser() {
        // get comment ID and user who disliked comment
        $comment = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // retrieve like if user disliked comment
        $sql_statement = "SELECT * FROM dislikes WHERE username=$username AND commentId=$comment";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return truth value on whether given user disliked the comment
        if ($sql_qry->num_rows > 0) {
            return true;
        }
        else {
            return false;
        };
    }

    // displays net count of likes/dislikes on comment
    public function totalReaction() {
        // get comment ID
        $comment = $this->getId();
        
        // retrieve total number of likes and rtotal number of dislikes
        $sql_statement = "SELECT (
                            SELECT count(*)
                            FROM likes
                            WHERE commentId=$comment
                            ) AS 'numLikes',
                            (
                            SELECT count(*)
                            FROM dislikes
                            WHERE commentId=$comment
                            ) AS 'numDislikes'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // retrieve the info & store in vars
        $data = $sql_qry->fetch_assoc();
        $likes = $data["numLikes"];
        $dislikes = $data["count"];
        
        // return the difference
        return $likes - $dislikes;
    }

    // method for comment 'Like' functionality
    public function likeComment() {
        // check if user has liked comment
        $comment = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // if they have, delete the like from the database
        if($this->LikedByUser()){
            // delete like for this content
            $sql_statement = "DELETE FROM likes WHERE username='$username' AND commentId='$comment'";
            $this->sqlcon->query($sql_statement);

            // update likes & dislikes on page
            $likes_change = -1;
            $dislikes_change = 0; 
            return $likes_change + $dislikes_change;
        }

        // if they haven't, add new like & delete dislike if it exists
        else {
            // add new like for this content
            $sql_statement = "INSERT INTO likes (username, commentId) VALUES ('$username', '$comment')";
            $this->sqlcon->query($sql_statement);

            // delete dislike for this content if it exists - cannot both like and dislike same content
            $sql_statement = "DELETE FROM dislikes WHERE username='$username' AND commentId='$comment'";
            $this->sqlcon->query($sql_statement);
            $count = $this->sqlcon->affected_rows;// count = num of dislikes removed
            
            // return net number of likes on comment (num of likes - num of dislikes + count)
            $likes_change = 1;
            $dislikes_change = 0 - $count; 
            return $likes_change + $dislikes_change;
        }
    }

    // method for comment 'Dislike' functionality
    public function dislikeComment() {
        //check if user has disliked content already
        $comment = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // delete from database if exists
        if($this->DislikedByUser()){
            // delete dislike
            $sql_statement = "DELETE FROM dislikes WHERE username='$username' AND commentId='$comment'";
            $this->sqlcon->query($sql_statement);

            // return net number of likes on comment (num of likes - num of dislikes + count)
            $likes_change = 0;
            $dislikes_change = -1; 
            return $likes_change + $dislikes_change;
        }

        // add new dislike otherwise, remove like if there
        else {
            // add new dislike
            $sql_statement = "INSERT INTO dislikes (username, commentId) VALUES ('$username', '$comment')";
            $this->sqlcon->query($sql_statement);

            // delete like if it exists
            $sql_statement = "DELETE FROM likes WHERE username='$username' AND commentId='$comment'";
            $this->sqlcon->query($sql_statement);
            $count = $this->sqlcon->affected_rows;
            
            // return net number of likes on comment (num of likes - num of dislikes + count)
            $likes_change = 0 - $count;
            $dislikes_change = 1; 
            return $likes_change + $dislikes_change;
        }
    }

    // get array of all responses to comment
    public function getResponses() {
        // get comment ID
        $comment = $this->getId();

        // retrieve any responses to comment
        $sql_statement = $this->sqlcon->prepare("SELECT * FROM comments WHERE responseTo=$comment ORDER BY datePosted ASC");
        $sql_qry= $this->sqlcon->query($sql_statement);

        // store all responses into an array
        $responses = "";
        $mediaId = $this->getMediaId();
        while($new_response = $sql_qry->fetch_assoc()) {
            $response = new Comment($this->sqlcon, $new_response, $this->logged_in_user, $mediaId);
            $responses .= $response->addComment();
        }

        // return array
        return $responses;
    }
}
?>