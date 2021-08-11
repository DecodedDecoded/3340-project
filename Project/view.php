<?php 
require_once("header.php");
require_once("VideoPlayer.php");
require_once("MediaInfoSection.php");



if(!isset($_GET["id"]))
{
    echo "No ID passed to page";
    exit();
}


$media = new Media($sqlcon, $_GET["id"], $userLoggedInObj);
$media->incrementViews();

?>
<script src="videoPlayerActions.js"></script>

<div class="watchLeftColumn">

<?php 
    $videoPlayer = new VideoPlayer($media);
    echo $videoPlayer->create(true);

    $MediaInfoSection = new MediaInfoSection($sqlcon, $media, $userLoggedInObj);
    echo $MediaInfoSection->create();
?>
</div>

<div class="suggestions">
    <?php
    $videoGrid = new VideoGrid($sqlcon, $userLoggedInObj);
    echo $videoGrid->create(null, null, false);
    ?>
</div>


<?php require_once("footer.php"); ?>