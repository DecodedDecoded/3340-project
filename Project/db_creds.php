<?php
    session_start();
    // Get the MySQL connection info
    $servername = "localhost";
    $username = "ahmed16r_project3340";
    $password = "Sp@rkStr1ngSyst3m";
    $db = "ahmed16r_project3340";

    // launch the connection
    $sqlcon = mysqli_connect($servername, $username, $password, $db);
    if (!$sqlcon) {
        die("Failure: " . mysqli_connect_error());
    }
?>