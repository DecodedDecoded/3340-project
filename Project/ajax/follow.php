<?php 
require_once("../db_creds.php");

if(isset($_POST['userTo']) && (isset($_POST['userFrom']))) {
    
    $userTo = $_POST['userTo'];
    $userFrom = $_POST['userFrom'];

    //Check if user is subbed
    $SQL = "SELECT * FROM followers WHERE userTo='$userTo' AND userFrom='$userFrom'";
    $query = $sqlcon->query($SQL);

    if($query->num_rows == 0) {
        $SQL = "INSERT INTO followers(userTo, userFrom) VALUES ('$userTo', '$userFrom')";
        $query = $sqlcon->query($SQL);
    }
    else {
        $SQL = "DELETE FROM followers WHERE userTo='$userTo' AND userFrom='$userFrom'";
        $query = $sqlcon->query($SQL); 
    }

    $SQL = "SELECT * FROM followers WHERE userTo='$userTo'";
    $query = $sqlcon->query($SQL);
    echo $query->num_rows;

    //if not subbed - insert

    
}

else {
    echo "Missing a parameter in follow.php";
}


?>