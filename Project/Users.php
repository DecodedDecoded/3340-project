<?php
 require_once("ErrorMessages.php");
    // Class validates & inserts new users into database
    class Users {

        // class vars
        private $sqlcon;
        private $fn, $ln, $un, $em, $emvrf, $pw, $pwvrf;
        private $errors = array();

        public function __construct($sqlcon) {
            // con taken in equals private var con
            $this->sqlcon = $sqlcon;
        }

        public function login($un, $pw) {
            $pw = hash("sha512", $pw);

            $SQL = "SELECT * FROM users WHERE username='$un' AND password='$pw'";
            $query = $this->sqlcon->query($SQL);

            if(mysqli_num_rows($query) == 1){
                return true;
            }

            else {
                array_push($this->errors, ErrorMessages::$loginFailed);
                return false;
            }

            
        }

        public function addUser($fn, $ln, $un, $em, $emvrf, $pw, $pwvrf){
            $this->validateFirst($fn);
            $this->validateLast($ln);
            $this->validateUsername($un);
            $this->validateEmail($em, $emvrf);
            $this->validatePassword($pw, $pwvrf);

            if(empty($this->errors)){
                return $this->insertUser($fn, $ln, $un, $em, $pw);
            }
            else {
                return false;
            }
        }

        public function insertUser($fn, $ln, $un, $em, $pw) {
            
            $pw = hash("sha512", $pw);
            
            $profilePic = "imgs/default.png";
            
            $SQL = "INSERT INTO users (firstName, lastName, username, email, password, profilePic) VALUES ('$fn', '$ln', '$un', '$em', '$pw', '$profilePic')";

            return $this->sqlcon->query($SQL);
        }

        private function validateFirst($fn) {
            // make sure first name is between 1 and 30 characters long
            if(strlen($fn) < 1 || strlen($fn) > 30) {
                array_push($this->errors, ErrorMessages::$firstNameError);
            }
        }

        public function getErr($error) {
            if(in_array($error, $this->errors)){
                return "<span class=\"errorMessage\">$error</span>";
            }
        }

        private function validateLast($ln)
        {
            // make sure last name is between 1 and 30 characters long
            if(strlen($ln) < 1 || strlen($ln) > 30) {
                array_push($this->errors, ErrorMessages::$lastNameError);
            }
        }

        private function validateUsername($un)
        {
            if(strlen($un) < 5 || strlen($un) > 30) {
                array_push($this->errors, ErrorMessages::$usernameError);
                return;
            }

            $SQL = "SELECT username FROM users WHERE username = '$un'";
            $query = $this->sqlcon->query($SQL);

            if(mysqli_num_rows($query) != 0){
                array_push($this->errors, ErrorMessages::$usernameTaken);
            }

        }

        private function validateEmail($em, $emvrf)
        {
            if($em != $emvrf) {
                array_push($this->errors, ErrorMessages::$emailConfirmError);
                return;
            }

            if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errors, ErrorMessages::$emailInvalid);
                return;
            }

            $SQL = "SELECT email FROM users WHERE email= '$em'";
            $query = $this->sqlcon->query($SQL) or die($sqlcon->error);

            if(mysqli_num_rows($query) != 0){
                array_push($this->errors, ErrorMessages::$emailTaken);
            }
        }

        private function validatePassword($pw, $pwvrf)
        {
            if($pw != $pwvrf) {
                array_push($this->errors, ErrorMessages::$passConfirmError);
                return;
            }

            if(strlen($pw) < 5 || strlen($pw) > 30) {
                array_push($this->errors, ErrorMessages::$passwordLength);
                return;
            }
        }


    }
?>