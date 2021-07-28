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
            
        }

        private function validateUsername($un)
        {
            # code...
        }

        private function validateEmail($em, $emvrf)
        {
            # code...
        }

        private function validatePassword($pw, $pwvrf)
        {
            # code...
        }


    }
?>