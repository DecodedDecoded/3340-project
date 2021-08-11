<?php
    // Class validates & inserts new users into database
    class Users {

        // class vars
        private $db_connect;
        private $fn, $ln, $un, $em, $emvrf, $pw, $pwvrf;
        private $errors = array();

        public function __construct($db_connect) {
            // db_connect taken in equals private var db_connect
            $this->db_connect = $db_connect;
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
                
                // don't check the rest if error
                return;
            }
        }

        private function validateLast($ln)
        {
            // make sure last name is between 1 and 30 characters long
            if(strlen($ln) < 1 || strlen($ln) > 30) {
                array_push($this->errors, ErrorMessages::$lastNameError);
                
                // don't check the rest if error
                return;
            }

            // make sure username isn't already taken

        }

        private function validateUsername($un)
        {
            // make sure username is between 5 and 30 characters long
            if(strlen($un) < 5 || strlen($un) > 30) {
                array_push($this->errors, ErrorMessages::$usernameLengthError);
                
                // don't check the rest if error occurs
                return;
            }

            // sql query to retrieve username from Users table if it already exists
            $sql = $this->db_connect->prepare("SELECT Username FROM Users WHERE Username=:un");
            $sql->bindParam(":un", $un);
            $sql->execute();

            // make sure username does not already exist in database
            if($sql->rowCount() != 0) {
                array_push($this->errors, ErrorMessages::$usernameExistsError);
                
                // don't check the rest if error occurs
                return;
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
                
                // don't check the rest if error
                return;
            }
            
            // make sure password is in the proper format
            
            // make sure password and password confirm fields match

        }


    }
?>