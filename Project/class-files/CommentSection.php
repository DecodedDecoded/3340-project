<?php
class CommentSection {

    private $sqlcon, $media, $userLoggedInObj;

    public function __construct($sqlcon, $media, $userLoggedInObj) {
        $this->sqlcon = $sqlcon;
        $this->media = $media;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        return $this->createCommentSection();
    }

    private function createCommentSection() {
        $numComments = $this->media->getNumberOfComments();
        $postedBy = $this->userLoggedInObj->getUsername();
        $videoId = $this->media->getId();

        $profileButton = ButtonProvider::createUserProfileButton($this->sqlcon, $postedBy);
        $commentAction = "postComment(this, \"$postedBy\", $videoId, null, \"comments\")";
        $commentButton = ButtonProvider::createButton("COMMENT", null, $commentAction, "postComment");
        
        $comments = $this->media->getComments();
        $commentItems = "";
        foreach($comments as $comment) {
            $commentItems .= $comment->create();
        }

        return "<div class='commentSection'>

                    <div class='header'>
                        <span class='commentCount'>$numComments Comments</span>

                        <div class='commentForm'>
                            $profileButton
                            <textarea class='commentBodyClass' placeholder='Add a public comment'></textarea>
                            $commentButton
                        </div>
                    </div>

                    <div class='comments'>
                        $commentItems
                    </div>

                </div>";
    }

}
?>