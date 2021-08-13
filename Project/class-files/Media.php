<!-- Class to carry Media content details & provide functionality for both new and existing media -  -->
<?php
class Media {
    
    // private vars: sql connection, database table data, object for user info 
    private $sqlcon, $table_data, $logged_in_user;

    // construct
    public function __construct($sqlcon, $logged_in_user, $content) {
        // stores global variables in local vars
        $this->sqlcon = $sqlcon;
        $this->logged_in_user =  $logged_in_user;

        // checks if media file is an array - for new file, upload it
        if(is_array($content)) {
            $this->table_data = $content;
        }

        // if not, file already exists - for existing file, retrieve it
        else {
            $sql_statement = "SELECT * from media WHERE id = '$content'";
            $sql_qry = $this->sqlcon->query($sql_statement);
            $this->table_data = $sql_qry->fetch_assoc();
        }
    }

    // get methods

    // content id
    public function getId() {
        return $this->table_data["id"];
    }

    // get content thumbnail
    public function getThumbnail(){
        // get content ID
        $contentId = $this->getId();

        // get file path of content's thumbnail image
        $sql_statement = "SELECT filePath FROM thumbnails WHERE videoid='$contentId'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // object that contains fetched thumbnail
        $thumbnail = $sql_qry->fetch_object();

        // return thumbnail's file path
        return $thumbnail->filePath;
    }

    // name (title) of content
    public function getTitle() {
        return $this->table_data["title"];
    }

    // content description
    public function getDescr() {
        return $this->table_data["description"];
    }

    // content privacy setting: public or private
    public function getPrivacy() {
        return $this->table_data["privacy"];
    }

    // content file path
    public function getFPath() {
        return $this->table_data["filePath"];
    }

    // content category
    public function getCategory() {
        return $this->table_data["category"];
    }

    // name of user who uploaded content
    public function getUserUploadedBy() {
        return $this->table_data["uploadedBy"];
    }

    // date content was uploaded
    public function getUploadDate() {
        $date = $this->table_data["uploadDate"];
        return date("M j, Y", strtotime($date));
    }

    // number of views content has
    public function getNumViews() {
        return $this->table_data["views"];
    }

    // add new view to Views count of content being displayed
    public function newView() {
        // get content ID
        $contentId = $this->getId();

        // sql statement to update views count
        $sql_statement = "UPDATE media SET views=views+1 WHERE id = '$contentId'";
        
        // execute statement
        $this->sqlcon->query($sql_statement);
        
        // update views count in field
        $this->table_data["views"] = $this->table_data["views"] + 1;
    }

    // retrieve number of likes piece of content has
    public function getNumLikes() {
        // get content ID & use to get number of likes on content
        $contentId = $this->getId();
        $sql_statement = "SELECT count(*) as 'count' FROM likes WHERE mediaId='$contentId'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // retrieve resulting data
        $sql_result = $sql_qry->fetch_assoc();

        return $sql_result["count"];
    }

    // retrieve number of dislikes piece of content has
    public function getNumDislikes() {
        // get content ID & use to get number of dislikes on content
        $contentId = $this->getId();
        $sql_statement = "SELECT count(*) as 'count' FROM dislikes WHERE mediaId='$contentId'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // retrieve results
        $sql_result = $sql_qry->fetch_assoc();

        return $sql_result["count"];
    }

    // get number of comments on content
    public function getNumComments() {
        // get content ID & use to get number of comments
        $contentId = $this->getId();
        $sql_statement = "SELECT * FROM comments WHERE mediaId=$contentId";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return number of comment records retrieved
        return $sql_qry->num_rows;
    }

    // get array of all comments under content in comment section
    public function getAllComments() {
        // get content ID & use to get all comments under content
        $contentId = $this->getId();
        $sql_statement = "SELECT * FROM comments WHERE mediaId=$contentId AND responseTo=0 ORDER BY datePosted DESC";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // store them in an array
        $comments = array();
        while($new_row = $sql_qry->fetch_assoc()) {
            $next_comment = new Comment($this->sqlcon, $new_row, $this->logged_in_user, $contentId);
            array_push($comments, $next_comment);
        }

        // return the array of comments
        return $comments;
    }

    // 'like' functionality
    
    // check if user has liked this content
    public function LikedByUser() {
        // get content ID and viewer's username 
        $contentId = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // retrieve user's like from database if it exists
        $sql_statement = "SELECT * FROM likes WHERE username='$username' AND mediaId='$contentId'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return truth value of whether like exists or not
        if($sql_qry->num_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // method for 'Like' button: adds or removes like from content
    public function likeMedia(){
        // check if user has liked the content already
        $contentId = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // if they have, delete the like from the database
        if($this->LikedByUser()){
            // delete like for this content
            $sql_statement = "DELETE FROM likes WHERE username='$username' AND mediaId='$contentId'";
            $this->sqlcon->query($sql_statement);

            // update likes & dislikes on media
            $sql_result = array("likes" => -1, "dislikes" => 0);
            return json_encode($sql_result);
        }

        // if they haven't, add new like & delete dislike if it exists
        else {
            // add new like for this content
            $sql_statement = "INSERT INTO likes (username, mediaId) VALUES ('$username', '$contentId')";
            $this->sqlcon->query($sql_statement);

            // delete dislike for this content if it exists - cannot both like and dislike same content
            $sql_statement = "DELETE FROM dislikes WHERE username='$username' AND mediaId='$contentId'";
            $this->sqlcon->query($sql_statement);
            $count = $this->sqlcon->affected_rows;
            
            // update likes & dislikes on media
            $sql_result = array("likes" => 1, "dislikes" => 0 - $count);
            return json_encode($sql_result);
        }
    }

    // 'dislike' functionality

    // check if user has liked this content
    public function DislikedByUser() {
        // get content ID and viewer's username
        $contentId = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // retrieve dislike from database if it exists
        $sql_statement = "SELECT * FROM dislikes WHERE username='$username' AND mediaId='$contentId'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // return truth value of whether dislike exists or not
        if($sql_qry->num_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // method for 'Dislike' button: adds or removes dislike from content
    public function dislikeMedia(){
        //check if user has disliked content already
        $contentId = $this->getId();
        $username = $this->logged_in_user->getUsername();

        // delete from database if exists
        if($this->DislikedByUser()){
            // delete dislike
            $sql_statement = "DELETE FROM dislikes WHERE username='$username' AND mediaId='$contentId'";
            $this->sqlcon->query($sql_statement);

            // update likes & dislikes on media
            $sql_result = array("likes" => 0, "dislikes" => -1);
            return json_encode($sql_result);
        }

        // add new dislike otherwise, remove like if there
        else {
            // add new dislike
            $sql_statement = "INSERT INTO dislikes (username, mediaId) VALUES ('$username', '$contentId')";
            $this->sqlcon->query($sql_statement);

            // delete like if it exists
            $sql_statement = "DELETE FROM likes WHERE username='$username' AND mediaId='$contentId'";
            $this->sqlcon->query($sql_statement);
            $count = $this->sqlcon->affected_rows;
            
            // update likes & dislikes on media
            $sql_result = array("likes" => 0 - $count, "dislikes" => 1);
            return json_encode($sql_result);
        }
    }
}

?>
