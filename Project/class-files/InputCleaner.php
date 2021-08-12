<?php
    class InputCleaner {
        // Functions can be called outside class without making CleanInput object
        
        public static function cleanName($inputVar) {
            // Remove html tags for security to avoid malicious code
            $inputVar = strip_tags($inputVar);

            // Remove spaces at ends & uppercase first letter
            $inputVar = trim($inputVar);
            $inputVar = strtolower($inputVar);
            $inputVar = ucfirst($inputVar);
            
            return $inputVar;
        }

        // function to clean username
        public static function cleanUsername($inputVar) {
            // Remove html tags for security to avoid malicious code
            $inputVar = strip_tags($inputVar);

            // Remove spaces in username - not allowed
            $inputVar = str_replace(" ", "", $inputVar);
            
            return $inputVar;
        }

        // function to clean email address
        public static function cleanEmail($inputVar) {
            // Remove html tags for security to avoid malicious code
            $inputVar = strip_tags($inputVar);

            // Remove spaces in username - not allowed
            $inputVar = str_replace(" ", "", $inputVar);
            
            // lowercase letters
            // split email 'address@website.com' into 3 parts: 'address', 'website', 'com'
            $inputString = preg_split("/[@.]/", $inputVar);

            // make sure all the text are lowercase
            $inputString[0] = strtolower($inputString[0]);
            $inputString[1] = strtolower($inputString[1]);
            $inputString[2] = strtolower($inputString[2]);

            // recombine email address
            $inputVar  = $inputString[0] . "@" . $inputString[1] . "." . $inputString[2];
            
            return $inputVar;
        }

        // function to clean password
        public static function cleanPassword($inputVar) {
            // Remove html tags for security to avoid malicious code
            $inputVar = strip_tags($inputVar);
            return $inputVar;
        }
    }
?>