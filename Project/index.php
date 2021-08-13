<!-- Header -->
<?php require_once "header.php"; ?>

<!-- section for main content of homepage: media, suggestions, etc. -->
<div class='main_section'>
    <?php
    
    // object that provides methods to get content of creators that the user follows
    $ffVendor = new FollowingVendor($sqlcon, $logged_in_user);

    // method to get content
    $followedMedia = $ffVendor->getVideos();

    // object that contains html to display media items
    $videoGrid = new VideoGrid($sqlcon, $logged_in_user->getUsername());

    // grabs content of creators user follows as long as user is logged in
    if(Account::isLoggedIn() && sizeof($followedMedia) > 0) {
        echo $videoGrid->create($followedMedia, "Subscriptions", false);
    }

    // grabs all content from media table
    echo $videoGrid->create(null, "Suggestions", false);
    ?>

</div>

<!-- Footer -->
<?php require_once "footer.php"; ?>