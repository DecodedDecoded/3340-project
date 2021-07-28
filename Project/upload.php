<?php 
require_once("header.php"); 
require_once("VideoDetailsFormProvider.php");
?>

<div class="column">

<?php
$formProvider = new VideoDetailsFormProvider($sqlcon);
echo $formProvider->createUploadForm();




?>

</div>


<?php require_once("footer.php"); ?>