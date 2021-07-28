<?php 
    if(!empty($_POST["reg_button"])){
        // Remove html tags for security to avoid malicious code
        // Remove spaces at ends & uppercase first letter
        function cleanInput($inputVar) {
            $inputVar = strip_tags($inputVar);
            $inputVar = trim($inputVar);
            $inputVar  = strtolower($inputVar);
            $inputVar = ucfirst($inputVar);
            return $inputVar;
        }
        
        // Get values from POST
        $reg_firstname = cleanInput($_POST["fname"]);
        $reg_lastname = cleanInput($_POST["lname"]);
        $reg_email = $_POST["email"];
        $em_confirm = $_POST["email_vrfy"];
        $reg_password = $_POST["password"];
        $pw_confirm = $_POST["password_vrfy"];

       
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
                    <form class="register__fields" method="post" action="<?php echo htmlspecialchars("register.php");?>">

                        <!-- First name. 'required' keyword prevents form from submitting if empty -->
                        <input type="text" name="fname" placeholder="Your first name" required>

                        <!-- Last name -->
                        <input type="text" name="lname" placeholder="Your last name" required>
                        
                        <!-- Username -->
                        <input type="text" name="username" placeholder="Your username" required>
                        
                        <!-- Email -->
                        <input type="email" name="email" placeholder="Your email address" required>
                        
                        <!-- Confirm email -->
                        <input type="email" name="email_vrfy" placeholder="Confirm email address" required>
                        
                        <!-- Password -->
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