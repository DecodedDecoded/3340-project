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

<script>
$("form").submit(function(){
    $("#loadingSpinner").modal("show");
});
</script>

<div class="modal fade" id="loadingSpinner" tabindex="-1" role="dialog" aria-labelledby="loadingSpinner" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        Please wait. This might take a while.
        <img src="imgs/loading-spinner.gif">
      </div>

    </div>
  </div>
</div>


<?php require_once("footer.php"); ?>