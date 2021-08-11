<?php
require_once("header.php");



$followingsProvider = new FollowingProvider($sqlcon, $userLoggedInObj);
$videos = $followingProvider->getVideos();

$videoGrid = new VideoGrid($sqlcon, $userLoggedInObj);
?>

<div class="largeVideoGridContainer">
    <?php
        if(sizeof($videos) > 0) {
            echo $videoGrid->createLarge($videos, "New from Following", false);
        }
        else {
            echo "No new media to show";
        }
    ?>
</div>