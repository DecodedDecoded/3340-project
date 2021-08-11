<?php
    // Class validates & inserts new users into database
    class Users {

        // class vars
        private $con;
        private $fn, $ln, $un, $em, $emvrf, $pw, $pwvrf;
        private $errors = array();

        public function __construct($con) {
            // con taken in equals private var con
            $this->con = $con;
        }

        public function addUser($fn, $ln, $un, $em, $emvrf, $pw, $pwvrf){
            $this->validateFirst($fn);
            $this->validateLast($ln);
            $this->validateUsername($un);
            $this->validateEmail($em, $emvrf);
            $this->validatePassword($pw, $pwvrf);
        }

        
        public function getErr($error) {
            if(in_array($error, $this->errors)){
                return "<span class=\"errorMessage\">$error</span>";
            }
        }
        
        private function validateFirst($fn) {
            // make sure first name is between 1 and 30 characters long
            if(strlen($fn) < 1 || strlen($fn) > 30) {
                array_push($this->errors, ErrorMessages::$firstNameError);
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
            // make sure first name is between 1 and 30 characters long
            if(strlen($un) < 1 || strlen($un) > 30) {
                array_push($this->errors, ErrorMessages::$usernameError);
            }
        }

        private function validateEmail($em, $emvrf)
        {
            // make sure email address is in the proper format
            // make sure email and email confirm fields match
        }

        private function validatePassword($pw, $pwvrf)
        {
            // make sure password is between 8 to 20 characters long
            if(strlen($pw) < 8 || strlen($pw) > 20) {
                array_push($this->errors, ErrorMessages::$passwordLengthError);
            }
            
            // make sure password is in the proper format
            
            // make sure password and password confirm fields match
            
        }


    }
?>