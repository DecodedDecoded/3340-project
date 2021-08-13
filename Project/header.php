<!--
    COMP-3340 Project, Team 1
    Date: August 13, 2021
    Written by: Donovan Longo & Abhilash Saksenaa
    Edited by: Dariq Ahmed & Henry Pham
-->

<!-- retrieve header includes -->
<?php require_once "header_includes.php"; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>HoardBird - COMP-3340 Project Team 1</title>
        <meta name="description" content="COMP-3340 Project, Team 1. A website where users can watch, upload, like and comment on content.">
        <meta name="keywords" content="COMP-3340, UWindsor, CompSci, HTML, JS, CSS, Javascript, Bootstrap, jQuery, HoardBird">
        <meta name="author" content="Team 1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="commonActions.js"></script>
        <script src="userActions.js"></script>
    </head>
<body>

    <!-- Main page container -->
    <div id="main_container">

        <!-- Div to handle everything in the header -->
        <div id="header_container">

            <!-- container for left-side components -->
            <div class="left_container">
                <!-- Menu Button -->
                <button class="navShowHide"> 
                    <img src="imgs/menu.png">
                </button>

                <!-- Website Logo -->
                <a class="logoContainer" href="index.php">
                    <img src="imgs/logo.png" title="logo" alt="Site Logo">
                </a>
            </div>

            <!-- Handles the search bar input and buttons -->
            <div class="searchBarContainer">
                <!-- Search bar form for PHP -->
                <form action="search.php" method="GET">
                    <!-- Search bar -->
                    <input type="text" class="searchBar" name="term" placeholder="Search ...">
                    
                    <!-- Search button -->
                    <button class="searchButton">
                    <img src="imgs/search.png" title="search" alt="Search Button">
                    </button>
                </form>
            </div>

            <!--Div for the icons that will be on the right side of the header -->
            <div class="rightIcons">
                <a href="upload.php">
                    <img class="upload" src="imgs/upload.png" title="upload" alt="Upload">
                </a>

                <?php echo BtnVendor::createProfileNavBtn($sqlcon, $logged_in_user->getUsername()); ?>
            </div>
        </div>

        <!--Div to handle everything in the side navigation bar -->
        <div id="sideNavContainer" style="display:none;">
            <?php
            $navMVendor = new NavMenuVendor($sqlcon, $logged_in_user);
            echo $navMVendor->create();
            ?>
        </div>

        <!--Div to handle everything in the main section -->
        <div id="mainSectionContainer">
            
            <!--Div to handle details of content within the main section-->
            <div id="mainContentContainer">