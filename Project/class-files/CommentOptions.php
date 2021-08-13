<!-- Class to add comment like/dislike buttons -->
<?php
// include
require "BtnVendor.php"; 

// class
class CommentOptions {

    // private variables - db connection, comment ID, current user
    private $sql_con, $comment, $logged_in_user;

    // construct
    public function __construct($sql_con, $comment, $logged_in_user) {
        // store private vars
        $this->sql_con = $sql_con;
        $this->comment = $comment;
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

    //
    private function addRespondBtn() {
        $text = "RESPOND";
        $action = "toggleRespond(this)";

        return BtnVendor::addBtn($text, null, $action, null);
    }

    //
    private function addNetLikes() {
        $text = $this->comment->getLikes();

        return "<span class='likesCount'>$text</span>";
    }

    //
    private function addRespondSection() {
        $postedBy = $this->logged_in_user->getUsername();
        $videoId = $this->comment->getVideoId();
        $commentId = $this->comment->getId();

        $profileBtn = BtnVendor::addProfileBtn($this->sql_con, $postedBy);
        
        $cancelBtnAction = "toggleRespond(this)";
        $cancelBtn = BtnVendor::addBtn("Cancel", null, $cancelBtnAction, "cancelComment");

        $postBtnAction = "postComment(this, \"$postedBy\", $videoId, $commentId, \"repliesSection\")";
        $postBtn = BtnVendor::addBtn("Respond", null, $postBtnAction, "postComment");

        return "<div class='commentForm hidden'>
                    $profileBtn
                    <textarea class='commentBodyClass' placeholder='Add a public comment'></textarea>
                    $cancelBtn
                    $postBtn
                </div>";
    }

    //
    private function addLikeBtn() {
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "likeComment($commentId, this, $videoId)";
        $class = "likeBtn";

        $imageSrc = "assets/images/icons/thumb-up.png";

        if($this->comment->wasLikedBy()) {
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }

        return BtnVendor::addBtn("", $imageSrc, $action, $class);
    }

    //
    private function addDislikeBtn() {
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "dislikeComment($commentId, this, $videoId)";
        $class = "dislikeBtn";

        $imageSrc = "assets/images/icons/thumb-down.png";

        if($this->comment->wasDislikedBy()) {
            $imageSrc = "assets/images/icons/thumb-down-active.png";
        }

        return BtnVendor::addBtn("", $imageSrc, $action, $class);
    }
}
?>