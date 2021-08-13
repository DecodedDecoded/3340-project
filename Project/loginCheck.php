<!-- Check if User is Logged In, Display User Profile Picture if True -->
<?php
    // check if user is logged in, show if true
    if(Account::isLoggedIn()) {
        $usernameLoggedIn = $_SESSION["userLoggedIn"];
    }

    // if not, show no user (set user to empty)
    else {
        $usernameLoggedIn = "";
    }

    // creates new user object
    $logged_in_user = new Account($sqlcon, $usernameLoggedIn);
?>