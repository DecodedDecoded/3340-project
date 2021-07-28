<?php
class VideoUploadData{

    //Variables for media
    public $mediaDataArray, $title, $description, $privacy, $category, $uploadedBy;

    //Constructor
    public function __construct($mediaDataArray, $title, $description, $privacy, $category, $uploadedBy){
        $this->mediaDataArray = $mediaDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->privacy = $privacy;
        $this->category = $category;
        $this->uploadedBy = $uploadedBy;
    }
}
?>