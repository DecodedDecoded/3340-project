<!-- Class to render buttons & provide their functionality methods -->
<?php 
class BtnVendor{
    // function to provide any button functionality
    // public static $loginFunction = "notSignedIn()";
    public static function createAction($button_action) {
        // return button action if user is logged in
        if(Account::isLoggedIn()) return $button_action;

        // if not logged in, return
        else return BtnVendor::notSignedIn();
    }

    // function to create any button
    public static function createBtn($text, $img_src, $action, $class){
        // save image source path
        if($img_src != null) $img = "<img src='$img_src'>";
        // if no image source, save empty string
        else $img = "";
       
        // return button functionality
       $onclick = BtnVendor::createAction($action);

       // return html element for button
        return "<button class='$class' onclick='$onclick'>
                    $img  
                    <span class='text'>$text</span>
                </button>";
    }

    // function to create any hyperlink
    public static function createHrefBtn($text, $img_src, $href, $class){
        // save image source path
        if($img_src != null) $img = "<img src='$img_src'>";
        // if no image source, save empty string
        else $img = "";
       
        // return html element for hyperlink
        return "<a href='$href'>
                    <button class='$class'>
                        $img  
                        <span class='text'>$text</span>
                    </button>
                </a>";
    }

    // create button to user profile
    public static function createProfileBtn($sqlcon, $username) {
        $user_object = new Account($sqlcon, $username);
        $pfp = $user_object->getPfp();
        $link = "profile.php?username=$username";

        // return html element for link to user profile
        return "<a href='$link'>
                    <img src='$pfp' class='profilePicture'>
                </a>";
    }

    // create button for content creator to edit their own content
    public static function createEditBtn($contentId) {
        // href link format
        $href = "edit.php?contentId=$contentId";

        // create hyperlink button to edit page
        $btn = BtnVendor::createHrefBtn("EDIT", null, $href, "edit_btn");

        // return html element for edit button
        return "<div class='editVideoButtonContainer'>
                    $btn
                </div>";
    }

    // create button to follow user
    public static function createFollowBtn($userTo_object, $logged_in_user) {
        // check if logged in user is following the user that this button links to
        $userTo = $userTo_object->getUsername();
        $current_user = $logged_in_user->getUsername();
        $isFollowing = $logged_in_user->isFollowing($userTo_object->getUsername());
        
        // change text inside button based on that
        // button text shows message as well as the creator's number of followers
        // if user follows content creator, button says 'Following'
        if($isFollowing) {
            $buttonText = "Following"  . " " . $userTo_object->getNumFollowers();;
        }
        // if not, button says 'Follow'
        else {
            $buttonText = "Follow"  . " " . $userTo_object->getNumFollowers();;
        }

        // set button's class based on whether user follows creator
        if($isFollowing){
            $button_class = "unfollow_btn";
        }
        else {
            $button_class = "follow_btn";
        }

        // create follow button
        $btn = BtnVendor::createBtn($buttonText, null, "follow(\"$userTo\", \"$current_user\", this)", $button_class);

        // return html element for button
        return "<div class='followButtonContainer'>$btn</div>";
    }

    // create element for profile button or sign in button in the nav bar
    public static function createProfileNavBtn($sqlcon, $username) {
        // return button to user's profile - this button is embedded in the user's profile pic
        if(Account::isLoggedIn()) {
            return BtnVendor::createProfileBtn($sqlcon, $username);
        }

        // return hyperlink to login page
        else {
            return "<a href='login.php'>
                    <span class='loginLink'>LOG IN</span>
                    </a>";
        }
    }
}
?>