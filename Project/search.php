<?php 
require_once("header.php");
require_once("SearchResultsProvider.php");


if(!isset($_GET['term']) || $_GET['term'] == "") {
    echo "You must enter a search term";
    exit();
}

$term = $_GET['term'];



if(!isset($_GET['orderBy']) || $_GET['orderBy'] == "views") {
    $orderBy = "views";
}

else {
    $orderBy = "uploadDate";
} 


$searchResultsProvider = new SearchResultsProvider($sqlcon, $userLoggedInObj);
$media = $searchResultsProvider->getMedia($term, $orderBy);

$videoGrid = new VideoGrid($sqlcon, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">

    <?php 

    if(sizeof($media) > 0) {
        echo $videoGrid->createLarge($media, sizeof($media) . " Media found     ", true);
    }

    else {
        echo "No results found";
    }

    ?>

</div>

<?php 
require_once("footer.php");

?>