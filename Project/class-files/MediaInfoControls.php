<?php
require_once("BtnVendor.php");
class MediaInfoControls {
   
    private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj){
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {

        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();
        return "<div class='controls'>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    private function createLikeButton(){
        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";

        $imageSrc = "imgs/thumb-up.png";

        if($this->video->wasLikedBy()){
            $imageSrc = "imgs/thumb-up-active.png";
        }

        return BtnVendor::createButton($text, $imageSrc, $action, $class);
    }

    private function createDislikeButton(){
        $text = $this->video->getDislikes();
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this, $videoId)";
        $class = "dislikeButton";

        $imageSrc = "imgs/thumb-down.png";

        if($this->video->wasDislikedBy()){
            $imageSrc = "imgs/thumb-down-active.png";
        }

        return BtnVendor::createButton($text, $imageSrc, $action, $class);
    }
}
?>