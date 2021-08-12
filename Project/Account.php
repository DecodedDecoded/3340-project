<?php
class Account {

    private $sqlcon, $sqlData;

    public function __construct($sqlcon, $username) {
        $this->sqlcon = $sqlcon;

        $SQL = "SELECT * from users WHERE username = '$username'";
        $query = $this->sqlcon->query($SQL);

        $this->sqlData = $query->fetch_assoc();
    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername() {
        return $this->sqlData["username"];
    }

    public function getName() {
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
    }

    public function getFirstName() {
        return $this->sqlData["firstName"];
    }

    public function getLastName() {
        return $this->sqlData["lastName"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profilePic"];
    }

    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }

    public function isFollowing($userTo) {
        $username = $this->getUsername();
        $SQL = "SELECT * FROM followers WHERE userTo = '$userTo' AND userFrom='$username'";
        $query = $this->sqlcon->query($SQL);
        
        if($query->num_rows > 0) {
            return true;
        }
        else {
            return false;
        } 
    
    }

    public function getFollowersCount() {
        $username = $this->getUsername();
        $SQL = "SELECT * FROM followers WHERE userTo = '$username'";
        $query = $this->sqlcon->query($SQL);
        return $query->num_rows;
        
    }

    public function getFollowing(){
        $username = $this->getUsername();
        $SQL = "SELECT userTo FROM followers WHERE userFrom='$username'";

        $query = $this->sqlcon->query($SQL);

        $following = array();
        while($row = $query->fetch_assoc()){
            $user = new Account($this->sqlcon, $row["userTo"]);
            array_push($following, $user);        }

            return $following;
    }

}

?>
