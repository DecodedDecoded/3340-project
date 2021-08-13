<!-- Class for comments rendering -->
<?php
class CommentSection {

    // private vars: db connection, media file, current user
    private $sqlcon, $media, $logged_in_user;

    // construct
    public function __construct($sqlcon, $media, $logged_in_user) {
        $this->sqlcon = $sqlcon;
        $this->media = $media;
        $this->logged_in_user = $logged_in_user;
    }

    // add comment section
    public function addCommentSection() {
        // get ID of media, the number of comments under it, and the current user's username
        $mediaId = $this->media->getId();
        $numComments = $this->media->getNumComments();
        $commentator = $this->logged_in_user->getUsername();
        

        // add and embed button to current user's profile page in pfp (profile pic)
        $profileBtn = BtnVendor::addProfileBtn($this->sqlcon, $commentator);
        $comment_action = "postComment(this, \"$commentator\", $mediaId, null, \"comments\")";
        $commentBtn = BtnVendor::addBtn("COMMENT", null, $comment_action, "postComment");
        
        //$media = new Media($this->sqlcon, $this->logged_in_user, $_GET["id"]);

        // store array of all comments under media 
        $comments = $this->media->getAllComments();

        // add section layouts for each comment & store in string
        $commentSections = "";
        foreach($comments as $comment) {
            // each comment section is added to the string
            $commentSections .= $comment->addCommentSection();
        }

        // return html for comment section
        return "<div class='comment_section'>
                    <div class='header_container'>
                        <span class='num_comments'>$numComments Comments</span>

                        <div class='comment_input_form'>
                            $profileBtn
                            <textarea class='commentBodyClass' placeholder='Add a public comment'></textarea>
                            $commentBtn
                        </div>
                    </div>

                    <div class='comments'>
                        $commentSections
                    </div>

                </div>";
    }
}
?>