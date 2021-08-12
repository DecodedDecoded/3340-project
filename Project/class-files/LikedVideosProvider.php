<?php
class LikedVideosProvider {

    private $sqlcon, $userLoggedInObj;

    public function __construct($sqlcon, $userLoggedInObj) {
        $this->sqlcon = $sqlcon;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideos() {
        $videos = array();

        $username = $this->userLoggedInObj->getUsername();
        $SQL = "SELECT videoId FROM likes WHERE username='$username' ORDER BY id DESC";

        $query = $this->sqlcon->query($SQL);
        

        while($row = $query->fetch_assoc()) {
            $video = new Media($this->sqlcon, $row["videoId"], $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }
}
?>