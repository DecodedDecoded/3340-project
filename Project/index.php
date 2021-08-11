<?php require_once("header.php"); ?>

<div class='videoSection'>
    <?php 
    $videoGrid = new VideoGrid($sqlcon, $userLoggedInObj->getUsername());
    echo $videoGrid->create(null, "Suggestions", false);
    
    ?>

</div>

<?php require_once("footer.php"); ?>