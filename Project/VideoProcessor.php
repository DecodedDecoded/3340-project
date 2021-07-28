<?php
class VideoProcessor{

    private $sqlcon;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg", "png", "jpg", "jpeg");

    public function __construct($sqlcon){
        $this->sqlcon = $sqlcon;
        $this->ffmpegPath = realpath("ffmpeg/windows/ffmpeg.exe");
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
            
            $mediaType = pathinfo($tempFilePath, PATHINFO_EXTENSION);
            $lowercased = strtolower($mediaType);
           if($lowercased == "mp4" || $lowercased == "flv" || $lowercased == "webm" || $lowercased == "mkv" || $lowercased == "vob" || $lowercased == "ogv" || $lowercased == "ogg" || $lowercased =="avi" || $lowercased =="wmv" || $lowercased =="mov" || $lowercased =="mpeg" || $lowercased =="mpg")
            {
                //File is a video
                if(!$this->insertMediaData($mediaUploadData, $tempFilePath)){
                    echo "Insert query failed";
                    return false;
                }
            }
            else{
                //File is a photo
                if(!$this->insertMediaData($mediaUploadData, $tempFilePath)){
                    echo "Insert query failed";
                    return false;
                }
            }
            

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

    private function insertMediaData($uploadData, $filePath){
        //Create media table - 10 columns: id, uploadedBy(VARHCAR 50), title (varchar 70), description (varchar 1000), privacy (int DEFAULT=0), filePath(varchar 250), category(int DEFAULT=0), uploadDate(DATETIME DEFUALT=CURRENT_TIMESTAMP), views(int DEFAULT=0), duration?, filetype?  
        $SQL = "INSERT INTO media(title, uploadedBy, description, privacy, category, filePath) VALUES($uploadData->title, $uploadData->uploadedBy, $uploadData->description, $uploadData->privacy, $uploadData->category, $filePath)";

        return $this->sqlcon->query($SQL);
    }

    
}
?>