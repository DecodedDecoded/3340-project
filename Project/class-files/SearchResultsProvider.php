<?php 
class SearchResultsProvider {

    private $sqlcon, $userLoggedinObj;

    public function __construct($sqlcon, $userLoggedinObj) {
        $this->sqlcon = $sqlcon;
        $this->userLoggedInObj = $userLoggedinObj;
    }

    public function getMedia($term, $orderBy) {
        $SQL = "SELECT * FROM media WHERE title LIKE CONCAT('%', '$term', '%') OR uploadedBy LIKE CONCAT('%', '$term', '%') ORDER BY $orderBy DESC";


        $query = $this->sqlcon->query($SQL);
        $mediaArray = array();
        while($row = $query->fetch_assoc()) {
            $media = new Media($this->sqlcon, $row, $this->userLoggedInObj);
            array_push($mediaArray, $media);
        }

        return $mediaArray;
        

    }



}
?>