<?php
require_once("header.php");
require_once("LikedVideosProvider.php");




$likedMediaProvider = new LikedVideosProvider($sqlcon, $userLoggedInObj);
$videos = $likedMediaProvider->getVideos();

$videoGrid = new VideoGrid($sqlcon, $userLoggedInObj);
?>

<div class="largeVideoGridContainer">
    <?php
        if(sizeof($videos) > 0) {
            echo $videoGrid->createLarge($videos, "Media you have liked", false);
        }
        else {
            echo "No new media to show";
        }
    ?>
</div>