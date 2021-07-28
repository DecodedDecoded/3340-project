<?php
class VideoProcessor{

    private $sqlcon;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg", "png", "jpg", "jpeg");

    public function __construct($sqlcon){
        $this->sqlcon = $sqlcon;
    }

    public function upload($mediaUploadData){

        $targetDir = "uploads/media/";
        $mediaData = $mediaUploadData->mediaDataArray;

        $tempFilePath = $targetDir . uniqid() . basename($mediaData['name']);

        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($mediaData, $tempFilePath);

        if(!$isValidData){
            return false;
        }

        if(move_uploaded_file($mediaData['tmp_name'], $tempFilePath)){
            echo "File moved successfully";
        }
    }

    private function processData($mediaData, $filePath){
        $mediaType = pathinfo($filePath, PATHINFO_EXTENSION);

        if(!$this->isValidSize($mediaData)){
            echo "File too large. The media cannot be more than " . $this->sizeLimit . " bytes.";
            return false;
        }
        else if(!$this->isValidType($mediaType)){
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($mediaData)){
            echo "Error code: " . $mediaData['error'];
            return false;
        }

        return true;
    }

    private function isValidSize($data){
        return $data['size'] <= $this->sizeLimit;
    }

    private function isValidType($type){
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }

    private function hasError($data){
        return $data['error'] != 0;
    }
}
?>