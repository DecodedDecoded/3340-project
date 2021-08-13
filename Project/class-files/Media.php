<!-- Class to carry Media content details & provide functionality for both new and existing media -  -->
<?php
class Media {
    
    // private vars: sql connection, database table data, object for user info 
    private $sqlcon, $table_data, $logged_in_user;

    // construct
    public function __construct($sqlcon, $content, $logged_in_user) {
        // stores global variables in local vars
        $this->sqlcon = $sqlcon;
        $this->logged_in_user =  $logged_in_user;

        // checks if media file is an array - for new file, upload it
        if(is_array($content)) {
            $this->table_data = $content;
        }

        // if not, file already exists - for existing file, retrieve it
        else {
            $SQL = "SELECT * from media WHERE id = '$content'";
            $sql_query = $this->sqlcon->query($SQL);
    
            $this->table_data = $sql_query->fetch_assoc();
        }
    }

    // get methods

    // id
    public function getId() {
        return $this->table_data["id"];
    }

    // name (title) of content
    public function getTitle() {
        return $this->table_data["title"];
    }

    // content description
    public function getDescription() {
        return $this->table_data["description"];
    }

    // content privacy setting: public or private
    public function getPrivacy() {
        return $this->table_data["privacy"];
    }

    // content file path
    public function getFilePath() {
        return $this->table_data["filePath"];
    }

    // content category
    public function getCategory() {
        return $this->table_data["category"];
    }

    // name of user who uploaded content
    public function getUploadedBy() {
        return $this->table_data["uploadedBy"];
    }

    // date content was uploaded
    public function getUploadDate() {
        $date = $this->table_data["uploadDate"];
        return date("M j, Y", strtotime($date));
    }

    // number of views content has
    public function getViews() {
        return $this->table_data["views"];
    }

    // add new view to Views count of content being displayed
    public function newView() {
        // get content ID
        $videoId = $this->getId();

        // sql statement
        $SQL = "UPDATE media SET views=views+1 WHERE id = '$videoId'";
        $sql_query = $this->sqlcon->query($SQL);
        
        $this->table_data["views"] = $this->table_data["views"] + 1;
    }

    // retrieve number of likes piece of content has
    public function getLikes() {
        $videoId = $this->getId();
        $SQL = "SELECT count(*) as 'count' FROM likes WHERE videoId='$videoId'";
        $sql_query = $this->sqlcon->query($SQL);

        $data = $sql_query->fetch_assoc();

        return $data["count"];
    }

    // retrieve number of dislikes piece of content has
    public function getDislikes() {
        $videoId = $this->getId();
        $SQL = "SELECT count(*) as 'count' FROM dislikes WHERE videoId='$videoId'";
        $query = $this->sqlcon->query($SQL);

        $data = $query->fetch_assoc();

        return $data["count"];
    }

    // 'like' functionality
    public function like(){
        // check if user has liked the video already
        $id = $this->getId();
        $username = $this->logged_in_user->getUsername();

        if($this->wasLikedBy()){
            // User has already liked
            $SQL = "DELETE FROM likes WHERE username='$username' AND videoId='$id'";
            $sql_query = $this->sqlcon->query($SQL);

            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );

            return json_encode($result);
        }
        else {
            //User has not liked yet
            $SQL = "DELETE FROM dislikes WHERE username='$username' AND videoId='$id'";
            $sql_query = $this->sqlcon->query($SQL);
            $count = $this->sqlcon->affected_rows;


            $SQL = "INSERT INTO likes (username, videoId) VALUES ('$username', '$id')";
            $sql_query = $this->sqlcon->query($SQL);
            
            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );

            return json_encode($result);
        }
    }

    // 'dislikw' functionality
    public function dislike(){
        //check if user has liked the video already
        $id = $this->getId();
        $username = $this->logged_in_user->getUsername();

        if($this->wasDislikedBy()){
            //User has already disliked
            $SQL = "DELETE FROM dislikes WHERE username='$username' AND videoId='$id'";
            $query = $this->sqlcon->query($SQL);

            $result = array(
                "likes" => 0,
                "dislikes" => -1
            );

            return json_encode($result);
        }
        else {
            //User has not disliked yet
            $SQL = "DELETE FROM likes WHERE username='$username' AND videoId='$id'";
            $query = $this->sqlcon->query($SQL);
            $count = $this->sqlcon->affected_rows;


            $SQL = "INSERT INTO dislikes (username, videoId) VALUES ('$username', '$id')";
            $query = $this->sqlcon->query($SQL);
            
            $result = array(
                "likes" => 0 - $count,
                "dislikes" => 1
            );

            return json_encode($result);
        }
    }

    public function wasLikedBy() {
        $id = $this->getId();
        $username = $this->logged_in_user->getUsername();

        $SQL = "SELECT * FROM likes WHERE username='$username' AND videoId='$id'";
        $query = $this->sqlcon->query($SQL);

        return mysqli_num_rows($query) > 0;

    }

    public function wasDislikedBy() {
        $id = $this->getId();
        $username = $this->logged_in_user->getUsername();

        $SQL = "SELECT * FROM dislikes WHERE username='$username' AND videoId='$id'";
        $query = $this->sqlcon->query($SQL);

        return mysqli_num_rows($query) > 0;

    }

    public function getThumbnail(){
        $videoId = $this->getId();
        $SQL = "SELECT filePath FROM thumbnails WHERE videoid='$videoId'";

        $query = $this->sqlcon->query($SQL);
        $obj = $query->fetch_object();
        //echo $obj->filePath;

        return $obj->filePath;
    }



   
}

?>
