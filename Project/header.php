<!DOCTYPE html>
<html>
    <head>
        <title>HoardBoard.com - COMP-3340 Project Team 1</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <scriot src="commonActions.js">
    </head>
<body>

    <!--Main page container -->
    <div id="pageContainer">

        <!--Div to handle everything in the header -->
        <div id="mastHeadContainer">

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
                    <input type="text" class="searchBar" name="term" placeholder="Search">
                    
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

                <a href="login.php">
                    <img class="upload" src="imgs/default.png" title="profile" alt="Profile Picture">
                </a>
            </div>
        </div>

        <!--Div to handle everything in the side navigation bar -->
        <div id="sideNavContainer" style="display:none;">

        </div>

        <!--Div to handle everything in the main section -->
        <div id="mainSectionContainer">
            
            <!--Div to handle details of content within the main section-->
            <div id="mainContentContainer">