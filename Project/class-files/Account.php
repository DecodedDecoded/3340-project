<!-- Class for User Information: both new & existing-->
<?php
class Account {

    // private vars: sql connection & database table data
    private $sqlcon, $table_data;

    // construct
    public function __construct($sqlcon, $username) {
        // stores global connection in local var
        $this->sqlcon = $sqlcon;

        // sql query
        $SQL = "SELECT * from users WHERE username = '$username'";
        $sql_query = $this->sqlcon->query($SQL);

        // variable that holds function to retrieve result of sql query
        $this->table_data = $sql_query->fetch_assoc();
    }

    // check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    // get functions

    // full name
    public function getFullName() {
        return $this->table_data["firstName"] . " " . $this->table_data["lastName"];
    }

    // first name only
    public function getFirstName() {
        return $this->table_data["firstName"];
    }

    // last name only
    public function getLastName() {
        return $this->table_data["lastName"];
    }

    // email address
    public function getEmailAddress() {
        return $this->table_data["email"];
    }

    // username
    public function getUsername() {
        return $this->table_data["username"];
    }

    // profile picture
    public function getPfp() {
        return $this->table_data["profilePic"];
    }

    // user registration date
    public function getRegistrationDate() {
        return $this->table_data["signUpDate"];
    }

    // Code for view.php - the page where users can view content like videos

    // on a content item, checks if user viewing the page (viewer) is a follower of the content's creator (creator)
    public function isFollowing($userTo) {

        // get viewer username
        $username = $this->getUsername();

        // retrieve creator from the followers database if they exist
        $SQL = "SELECT * FROM followers WHERE userTo = '$userTo' AND userFrom='$username'";
        $sql_query = $this->sqlcon->query($SQL);
        
        // return truth value of whether user follows content creator or not
        if($sql_query->num_rows > 0) {
            return true;
        }
        else {
            return false;
        } 
    
    }

    // number of followers creator has to display in content info
    public function getFollowersCount() {
        $username = $this->getUsername();

        // retrieves any followers creator has
        $SQL = "SELECT * FROM followers WHERE userTo = '$username'";
        
        // returns number of rows in retrieved table data
        $sql_query = $this->sqlcon->query($SQL);
        return $sql_query->num_rows;
    }

    // gets array of all users that follow the viewer
    public function getFollowing(){
        $username = $this->getUsername();

        // select all followers of user's following
        $SQL = "SELECT userTo FROM followers WHERE userFrom='$username'";

        $query = $this->sqlcon->query($SQL);

        // store them in an array
        $following = array();
        while($row = $query->fetch_assoc()){
            $user = new Account($this->sqlcon, $row["userTo"]);
            array_push($following, $user);
        }

        // return the array
        return $following;
    }
}
?>
