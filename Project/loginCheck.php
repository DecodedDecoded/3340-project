<!-- Check if User is Logged In, Display User Profile Picture if True -->
<?php
    // check if user is logged in, show if true
    if(Account::isLoggedIn()) {
        $current_user = $_SESSION["userLoggedIn"];
    }

    // if not, show no user (set user to empty)
    else {
        $current_user = "";
    }

    // creates object to carry user info
    $logged_in_user = new Account($sqlcon, $current_user);
?>