<?php
    session_start();
    // Get the MySQL connection info
    $servername = "localhost";
    $username = "ahmed16r_project3340";
    $password = "Sp@rkStr1ngSyst3m";
    $db = "ahmed16r_project3340";

    // set default date and time
    date_default_timezone_set("America/Toronto");

    // launch the connection
    $sqlcon = new mysqli($servername, $username, $password, $db);
    
    // check if connection failed
    if ($sqlcon->connect_error) {
        die("Failure: " . mysqli_connect_error());
    }
?>