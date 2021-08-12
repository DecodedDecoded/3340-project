<?php require_once("header.php"); ?>

<div class='videoSection'>
    <?php
    
    $subscriptionsProvider = new SubscriptionsProvider($sqlcon, $userLoggedInObj);
    $subscriptionVideos = $subscriptionsProvider->getVideos();

    $videoGrid = new VideoGrid($sqlcon, $userLoggedInObj->getUsername());

    if(Account::isLoggedIn() && sizeof($subscriptionVideos) > 0) {
        echo $videoGrid->create($subscriptionVideos, "Subscriptions", false);
    }

    echo $videoGrid->create(null, "Suggestions", false);
    ?>

</div>

<?php require_once("footer.php"); ?>