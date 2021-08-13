<!-- Class to add comment like/dislike buttons -->
<?php
// include
require "BtnVendor.php"; 

// class
class CommentOptions {

    // private variables - db connection, comment object, current user
    private $sql_con, $comment_object, $logged_in_user;

    // construct
    public function __construct($sql_con, $comment_object, $logged_in_user) {
        // store private vars
        $this->sql_con = $sql_con;
        $this->comment_object = $comment_object;
        $this->logged_in_user = $logged_in_user;
    }

    // function to add option buttons
    public function addOptionBtns() {
        // add each button in options
        $respondBtn = $this->addRespondBtn(); // respond button
        $net_likes = $this->addNetLikes(); // net number of likes on comment
        $likeBtn = $this->addLikeBtn(); // like button
        $dislikeBtn = $this->addDislikeBtn(); // dislike button
        $respondSection = $this->addRespondSection(); // section for replies
        
        // return html for comment options
        return "<div class='controls'>
                    $net_likes
                    $likeBtn
                    $dislikeBtn
                    $respondBtn
                </div>
                $respondSection";
    }

    // add button to respond to comment
    private function addRespondBtn() {
        // text & toggle for button
        $text = "RESPOND";
        $action = "toggleRespond(this)";

        // add response button
        return BtnVendor::addBtn($text, null, $action, null);
    }

    // add button to display net likes on comment
    private function addNetLikes() {
        $text = $this->comment_object->getLikes();

        return "<span class='likesCount'>$text</span>";
    }

    // add section for responses to comment
    private function addRespondSection() {
        // get username of current user, IDs of media & comment under media
        $commentator = $this->logged_in_user->getUsername();
        $mediaId = $this->comment_object->getMediaId();
        $comment = $this->comment_object->getId();

        // add button to profile embedded in username
        $profileBtn = BtnVendor::addProfileBtn($this->sql_con, $commentator);
        
        // add cancel button for comment
        $cancelBtn_action = "toggleRespond(this)";
        $cancelBtn = BtnVendor::addBtn("CANCEL", null, $cancelBtn_action, "cancel_comment");

        // add submit button for comment
        $submitBtn_action = "postComment(this, \"$commentator\", $mediaId, $comment, \"repliesSection\")";
        $submitBtn = BtnVendor::addBtn("RESPOND", null, $submitBtn_action, "submit_omment");

        // return html for response section
        return "<div class='commentForm hidden'>
                    $profileBtn
                    <textarea class='commentBodyClass' placeholder='Add a public comment'></textarea>
                    $cancelBtn
                    $submitBtn
                </div>";
    }

    // add 'Like' button for comment
    private function addLikeBtn() {
        $comment = $this->comment_object->getId();
        $mediaId = $this->comment_object->getMediaId();
        $action = "likeComment($comment, this, $mediaId)";
        $class = "likeBtn";

        $img_src = "imgs/thumb-up.png";

        if($this->comment_object->LikedByUser()) {
            $img_src = "imgs/thumb-up-active.png";
        }

        return BtnVendor::addBtn("", $img_src, $action, $class);
    }

    // add 'Dislike' button for comment
    private function addDislikeBtn() {
        $commentId = $this->comment_object->getId();
        $videoId = $this->comment_object->getMediaId();
        $action = "dislikeComment($commentId, this, $videoId)";
        $class = "dislikeBtn";

        $img_src = "imgs/thumb-down.png";

        if($this->comment_object->DislikedByUser()) {
            $img_src = "imgs/thumb-down-active.png";
        }

        return BtnVendor::addBtn("", $img_src, $action, $class);
    }
}
?>