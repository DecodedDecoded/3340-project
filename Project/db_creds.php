<?php
    session_start();
    // Get the MySQL connection info
    $servername = "localhost";
    $username = "longo114_FinalProject";
    $password = "test";
    $db = "longo114_FinalProject";

    // launch the connection
    $sqlcon = mysqli_connect($servername, $username, $password, $db);
    if (!$sqlcon) {
        die("Failure: " . mysqli_connect_error());
    }
?>