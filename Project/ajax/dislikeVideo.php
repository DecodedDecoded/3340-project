<?php
require_once("../db_creds.php");
require_once("../Media.php");
require_once("../Account.php");


$username = $_SESSION["userLoggedIn"];
$videoId = $_POST["videoId"];

$userLoggedInObj = new Account($sqlcon, $username);

$video = new Media($sqlcon, $videoId, $userLoggedInObj);

echo $video->dislike();
?>