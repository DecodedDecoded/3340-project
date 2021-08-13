<?php 
class BtnVendor{

    public static $signInFunction = "notSignedIn()";
    public static function createLink($link) {
        if(Account::isLoggedIn())
        {
            return $link;
        }
        else {
            return BtnVendor::$signInFunction;
        }
    }

    public static function createButton($text, $imageSrc, $action, $class){
        
        if($imageSrc == null){
            $image = "";
        }
        else {
            $image = "<img src='$imageSrc'>";
        }
       
       $action = BtnVendor::createLink($action);
       
        return "<button class='$class' onclick='$action'>
                    $image  
                    <span class='text'>$text</span>
                </button>";
    }

    public static function createHyperlinkButton($text, $imageSrc, $href, $class){
        
        if($imageSrc == null){
            $image = "";
        }
        else {
            $image = "<img src='$imageSrc'>";
        }
       
        return "<a href='$href'>
                    <button class='$class' >
                        $image  
                        <span class='text'>$text</span>
                    </button>
                </a>";
    }

    public static function createUserProfileButton($sqlcon, $username) {
        $userObj = new Account($sqlcon, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link'>
                    <img src='$profilePic' class='profilePicture'>
                </a>";
    }

    public static function createFollowerButton($sqlcon, $userToObj, $userLoggedInObj) {
        $userTo = $userToObj->getUsername();
        $userLoggedIn = $userLoggedInObj->getUsername();

        $isFollowedTo = $userLoggedInObj->isFollowedTo($userToObj->getUsername());
        
        if($isFollowedTo){
            $buttonText = "Following";
        }
        else {
            $buttonText = "Follow";
        }
        
        $buttonText = $buttonText . " " . $userToObj->getFollowersCount();

      
        if($isFollowedTo){
            $buttonClass = "unfollow button";
        }
        else {
            $buttonClass = "follow button";
        }

        $action = "follow(\"$userTo\", \"$userLoggedIn\", this)";

        $button = BtnVendor::createButton($buttonText, null, $action, $buttonClass);

        return "<div class='followButtonContainer'>$button</div>";

    }

    public static function createUserProfileNavigationButton($sqlcon, $username) {
        if(Account::isLoggedIn()) {
            return BtnVendor::createUserProfileButton($sqlcon, $username);
        }

        else {
            return "<a href='login.php'>
                    <span class='signInLink'>SIGN IN</span>
                    </a>";
        }
    }

}
?>