
<?php 
    require_once("db_creds.php");
    require_once("InputCleaner.php");
    require_once("Users.php");
    require_once("ErrorMessages.php");

    $user = new Users($sqlcon);


    if(isset($_POST["reg_button"])){
        $firstName = InputCleaner::cleanName($_POST["fname"]);
        $lastName = InputCleaner::cleanName($_POST["lname"]);
        
        $username = InputCleaner::cleanUsername($_POST["username"]);
        
        $email = InputCleaner::cleanEmail($_POST["email"]);
        $confirmEmail = InputCleaner::cleanEmail($_POST["email_vrfy"]);
        
        $password = InputCleaner::cleanPassword($_POST["password"]);
        $confirmPassword = InputCleaner::cleanPassword($_POST["password_vrfy"]);
        
        $wasSuccessful = $user->addUser($firstName, $lastName, $username, $email, $confirmEmail, $password, $confirmPassword);

        if($wasSuccessful) {
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }

    }


    function getInputValue($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HoardBoard.com - Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="register.css">
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- container for entire page -->
        <div class="register__container">
            <!-- container for registration box in center -->
            <div class="register__box">
                <!-- container for header above input form -->
                <div class="register__header">
                    <!-- Website Logo -->
                    <a class="logo__container" href="index.php">
                        <img src="imgs/logo.png" title="logo" alt="Site Logo">
                    </a>

                    <!-- Message -->
                    <h3 class="reg__tag">Register Account</h3>
                    <span>Join the Hoard!</span>
                </div>

                <!-- container for registration form -->
                <div class="register__form">

                    <!-- Submit form for input fields, all fields must be filled before submission -->
                    <form class="register__fields" method="POST" action="register.php">

                        <!-- First name. 'required' keyword prevents form from submitting if empty -->
                        <?php echo $user->getErr(ErrorMessages::$firstNameError); ?>
                        <input type="text" name="fname" placeholder="Your first name" value="<?php getInputValue('fname'); ?>" required>

                        <!-- Last name -->
                        <?php echo $user->getErr(ErrorMessages::$lastNameError); ?>
                        <input type="text" name="lname" placeholder="Your last name" value="<?php getInputValue('lname'); ?>" required>
                        
                        <!-- Username -->
                        <?php echo $user->getErr(ErrorMessages::$usernameError); ?>
                        <?php echo $user->getErr(ErrorMessages::$usernameTaken); ?>
                        <input type="text" name="username" placeholder="Your username" value="<?php getInputValue('username'); ?>" required>
                        
                        <!-- Email -->
                        <?php echo $user->getErr(ErrorMessages::$emailConfirmError); ?>
                        <?php echo $user->getErr(ErrorMessages::$emailInvalid); ?>
                        <?php echo $user->getErr(ErrorMessages::$emailTaken); ?>
                        <input type="email" name="email" placeholder="Your email address" value="<?php getInputValue('email'); ?>" required>
                        
                        <!-- Confirm email -->
                        <input type="email" name="email_vrfy" placeholder="Confirm email address" value="<?php getInputValue('email_vrfy'); ?>" required>
                        
                        <!-- Password -->
                        <?php echo $user->getErr(ErrorMessages::$passConfirmError); ?>
                        <?php echo $user->getErr(ErrorMessages::$passwordLength); ?>
                        <input type="password" name="password" placeholder="Your password" required>
                        
                        <!-- Confirm password -->
                        <input type="password" name="password_vrfy" placeholder="Confirm password" required>
                    
                        <!-- Submit button -->
                        <input type="submit" name="reg_button" value="Submit">
                    </form>
                </div>
                
                <!-- Link to login if you already have an acct -->
                <a class="login_link" href="login.php">You already exist? Log In</a>
            </div>
        </div>
    </body>
</html>