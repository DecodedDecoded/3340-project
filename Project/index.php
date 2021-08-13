<!-- Header -->
<?php require_once "header.php"; ?>

<!-- section for main content of homepage: suggested media, etc. -->
<div class='main_section'>
    <?php
    // object that contains html to display media items
    $mediaGrid = new MediaGrid($sqlcon, $logged_in_user->getUsername());

    // grabs 15 items from media table to display in Featured content
    echo $mediaGrid->createGridContainer(null, "Featured", false, 15);
    ?>
</div>

<!-- Footer -->
<?php require_once "footer.php"; ?>