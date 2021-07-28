<?php
class VideoDetailsFormProvider{

    //Variables to store our sql connection
    private $sqlcon;

    //constructor
    public function __construct($sqlcon){
        $this->sqlcon = $sqlcon;
    }

    //Creates upload form html
    public function createUploadForm(){
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $privacyInput = $this->createPrivacyInput();
        $categoriesInput = $this->createCategoriesInput();
        $uploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoriesInput
                    $uploadButton
                </form>";
    }

    //Creates the file input portion of form
    private function createFileInput(){

        return "<div class='form-group'>
                    <label for='exampleFormControlFile1'>Your video/photo: </label>
                    <input type='file' class='form-control-file' id='exampleFormControlFile1' name='fileInput' required>
                </div>";
    }

    //Creates the title input portion of form
    private function createTitleInput(){
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='titeInput'>
                </div>";

        
    }

    //Creates the description input portion of form
    private function createDescriptionInput(){
        return "<div class='form-group'>
                    <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3'></textarea>
                </div>";   
    }

    //Creates the privacy input portion of form
    private function createPrivacyInput(){
        return "<div class='form-group'>
                    <select class='form-control' name='privacyInput'>
                        <option value='1'>Public</option>
                        <option value='0'>Private</option>
                    </select>
                </div>";

      
    }

    //Funciton that generates drop down of categories from our database
    private function createCategoriesInput(){
        $SQL="SELECT * FROM categories";
        $result = $this->sqlcon->query($SQL) or die($sqlcon->error);

        $html = "<div class='form-group'>
                    <select class='form-control' name='categoryInput'>";

        while($row = $result->fetch_assoc())
        {
            $name = $row['name'];
            $id = $row['id'];
            $html = $html . "<option value='$id'>$name</option>";
        }
        
        $html = $html . "</select>
                        </div>";
        
        return $html;

    }

    //Function that creates an upload button on the form
    private function createUploadButton(){
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }
}
?>