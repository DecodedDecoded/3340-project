<?php
class FollowingVendor {

    private $sqlcon, $userLoggedInObj;

    public function __construct($sqlcon, $userLoggedInObj) {
        $this->sqlcon = $sqlcon;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideos() {
        $videos = array();
        $subscriptions = $this->userLoggedInObj->getFollowing();
        if(sizeof($subscriptions) > 0) {

            $condition = "";
            $i = 0;

            while($i < sizeof($subscriptions)) {
                
                if($i == 0) {
                    $condition .= "WHERE uploadedBy=?";
                }
                else {
                    $condition .= " OR uploadedBy=?";
                }
                $i++;
            }

            $videoSql = "SELECT * FROM media $condition ORDER BY uploadDate DESC";
            $videoQuery = $this->sqlcon->prepare($videoSql);
            $i = 1;

            foreach($subscriptions as $sub) {

                $subUsername = $sub->getUsername();
                $videoQuery->bind_param($i, $subUsername);
                $i++;
            }

            $videoQuery->execute();
            while($row = $videoQuery->fetch_assoc()) {
                $video = new Media($this->sqlcon, $row, $this->userLoggedInObj);
                array_push($videos, $video);
            }

        }

        return $videos;

    }
    
}
?>