<?php
class Media {

    private $sqlcon, $sqlData, $userLoggedInObj;

    public function __construct($sqlcon, $input, $userLoggedInObj) {
        $this->sqlcon = $sqlcon;
        $this->userLoggedInObj =  $userLoggedInObj;


        if(is_array($input)) {
            $this->sqlData = $input;
        }

        else {
            $SQL = "SELECT * from media WHERE id = '$input'";
            $query = $this->sqlcon->query($SQL);
    
            $this->sqlData = $query->fetch_assoc();
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getPrivacy() {
        return $this->sqlData["privacy"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getCategory() {
        return $this->sqlData["category"];
    }

    public function getUploadDate() {
        $date = $this->sqlData["uploadDate"];
        return date("M j, Y", strtotime($date));
    }

    public function getViews() {
        return $this->sqlData["views"];
    }

    public function incrementViews() {
        $videoId = $this->getId();
        $SQL = "UPDATE media SET views=views+1 WHERE id = '$videoId'";
        $query = $this->sqlcon->query($SQL);
        
        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }

    public function getLikes() {
        $videoId = $this->getId();
        $SQL = "SELECT count(*) as 'count' FROM likes WHERE videoId='$videoId'";
        $query = $this->sqlcon->query($SQL);

        $data = $query->fetch_assoc();

        return $data["count"];
    }

    public function getDislikes() {
        $videoId = $this->getId();
        $SQL = "SELECT count(*) as 'count' FROM dislikes WHERE videoId='$videoId'";
        $query = $this->sqlcon->query($SQL);

        $data = $query->fetch_assoc();

        return $data["count"];
    }

    public function like(){
        //check if user has liked the video already
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()){
            //User has already liked
            $SQL = "DELETE FROM likes WHERE username='$username' AND videoId='$id'";
            $query = $this->sqlcon->query($SQL);

            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );

            return json_encode($result);
        }
        else {
            //User has not liked yet
            $SQL = "DELETE FROM dislikes WHERE username='$username' AND videoId='$id'";
            $query = $this->sqlcon->query($SQL);
            $count = $this->sqlcon->affected_rows;


            $SQL = "INSERT INTO likes (username, videoId) VALUES ('$username', '$id')";
            $query = $this->sqlcon->query($SQL);
            
            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );

            return json_encode($result);
        }
    }

    public function dislike(){
        //check if user has liked the video already
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

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
        $username = $this->userLoggedInObj->getUsername();

        $SQL = "SELECT * FROM likes WHERE username='$username' AND videoId='$id'";
        $query = $this->sqlcon->query($SQL);

        return mysqli_num_rows($query) > 0;

    }

    public function wasDislikedBy() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

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
