<?php
    class ErrorMessages {
        // error messages
        public static $firstNameError = "Your first name must be 1 to 30 characters long";
        public static $lastNameError = "Your last name must be 1 to 30 characters long";
        public static $usernameLengthError = "Your username must be 5 to 30 characters long";
        public static $usernameExistsError = "Username is unavailable";
        public static $emailFormatError = "Not a valid email address";
        public static $emailConfirmError = "Email addresses don't match";
        public static $passwordLengthError = "Password must be 8 to 20 characters long";
        public static $passwordFormatError = "Password must contain at least 1 letter and 1 number";
        public static $passwordConfirmError = "Passwords don't match";
        public static $usernameLoginError = "Username not found";
        public static $emailLoginError = "Email not found";
        public static $passwordLoginError = "Wrong password entered";
    }
?>