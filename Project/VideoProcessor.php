<?php
class VideoProcessor{

    private $sqlcon;

    public function __construct($sqlcon){
        $this->sqlcon = $sqlcon;
    }

    public function upload($mediaUploadData){

        $targetDir = "uploads/media/";
        $mediaData = $mediaUploadData->mediaDataArray;

        $tempFilePath = $targetDir . uniqid() . basename($mediaData['name']);

        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        echo $tempFilePath;
    }
}
?>