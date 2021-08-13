<!-- Includes for header.php -->
<?php
    // PHP includes
    require_once "db_creds.php"; // database connection credentials
    require_once "class-files/Account.php"; // class for new user acct creation
    require_once "loginCheck.php"; // check if user is logged in
    require_once "class-files/BtnVendor.php";// provides methods & rendering for diff buttons
    require_once "class-files/Media.php"; // class to hold media info
    require_once "class-files/MediaGrid.php";// class for content grid
    require_once "class-files/MediaItem.php";// class for individual item in content grid
    require_once "class-files/NavMenuVendor.php";// provides methods for the navigation menu
    require_once "class-files/FollowingVendor.php";// provides methods to get details of the user's followings
?>