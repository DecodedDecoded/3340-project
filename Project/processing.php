<?php 
require_once("header.php");
require_once("VideoUploadData.php");
require_once("VideoProcessor.php");

//Checks if upload button was pressed
if(!isset($_POST['uploadButton']))
{
    echo "No file sent to page";
    exit();
}

//Create a file upload data object
$mediaUploadData = new VideoUploadData($_FILES['fileInput'], $_POST['titleInput'], $_POST['descriptionInput'], $_POST['privacyInput'], $_POST['categoryInput'], "REPLACETHIS");

//Process the media data
$mediaProcessor = new VideoProcessor($sqlcon);
$wasSuccessful = $mediaProcessor->upload($mediaUploadData);

?>