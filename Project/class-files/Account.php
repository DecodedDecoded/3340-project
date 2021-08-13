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
        $sql_statement = "SELECT * from users WHERE username = '$username'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // variable that holds function to retrieve result of sql query
        $this->table_data = $sql_qry->fetch_assoc();
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
        $sql_statement = "SELECT * FROM followers WHERE userTo = '$userTo' AND userFrom='$username'";
        $sql_qry = $this->sqlcon->query($sql_statement);
        
        // return truth value of whether user follows content creator or not
        if($sql_qry->num_rows > 0) {
            return true;
        }
        else {
            return false;
        } 
    
    }

    // number of followers creator has to display in content info
    public function getNumFollowers() {
        $username = $this->getUsername();

        // retrieves any followers creator has
        $sql_statement = "SELECT * FROM followers WHERE userTo = '$username'";
        
        // returns number of rows in retrieved table data
        $sql_qry = $this->sqlcon->query($sql_statement);
        return $sql_qry->num_rows;
    }

    // gets array of all users that follow the viewer
    public function getFollowing(){
        $username = $this->getUsername();

        // select all followers of user's following
        $sql_statement = "SELECT userTo FROM followers WHERE userFrom='$username'";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // store them in an array
        $following = array();
        while($new_row = $sql_qry->fetch_assoc()){
            $next_follower = new Account($this->sqlcon, $new_row["userTo"]);
            array_push($following, $next_follower);
        }

        // return the array
        return $following;
    }
}
?>
