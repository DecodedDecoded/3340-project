<?php

require_once('MediaInfoControls.php');

class MediaInfoSection{
    private $sqlcon, $video, $userLoggedInObj;

    public function __construct($sqlcon, $video, $userLoggedInObj){
        $this->sqlcon = $sqlcon;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
       return $this->createPrimaryInfo() . $this->createSecondaryInfo();
    }

    private function createPrimaryInfo(){
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $mediaInfoControls = new MediaInfoControls($this->video, $this->userLoggedInObj);
        $controls = $mediaInfoControls->create();

        return "<div class='videoInfo'>
                    <h1>$title</h1>
                    
                    <div class='bottomSection'>
                        <span class='viewCount'>$views Views</span>
                        $controls
                    </div>
                </div>";
    }

    private function createSecondaryInfo(){

        $description = $this->video->getDescription();
        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileButton = ButtonProvider::createUserProfileButton($this->sqlcon, $uploadedBy);

        //Will not display follow button if user is viewing their own videos
        if($uploadedBy == $this->userLoggedInObj->getUsername()){

        }
        else {
            $userToObject = new Account($this->sqlcon, $uploadedBy);
            $actionButton = ButtonProvider::createFollowerButton($this->sqlcon, $userToObject, $this->userLoggedInObj);
        }

        return "<div class='secondaryInfo'>
                    <div class='topRow'>
                        $profileButton

                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>$uploadedBy</a>
                            </span>
                            <span class='date'>Shared on $uploadDate</span>
                        </div>
                        $actionButton
                    </div>

                    <div class='description'>$description</div>
                </div>";
    }
}

?>