<?php 
require_once("header.php"); 
require_once("VideoDetailsFormProvider.php");
?>

<div class="column">

<?php
$formProvider = new VideoDetailsFormProvider();
echo $formProvider->createUploadForm();
?>

</div>


<?php require_once("footer.php"); ?>