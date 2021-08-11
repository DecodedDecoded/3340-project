<?php
class NavigationMenuProvider {
    private $sqlcon, $userLoggedInObj;

    public function __construct($sqlcon, $userLoggedInObj) {
        $this->sqlcon = $sqlcon;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $menuHtml = $this->createNavItem("Home", "imgs/home.png", "index.php");
        $menuHtml .= $this->createNavItem("Following", "imgs/subscriptions.png", "followings.php");
        $menuHtml .= $this->createNavItem("Liked Videos", "imgs/thumb-up.png", "likedVideos.php");

        if(Account::isLoggedIn()){
            $menuHtml .= $this->createNavItem("Log Out", "imgs/logout.png", "logout.php");
        }


        return "<div class='navigationItems'>    
                    $menuHtml
                </div>";

    }

    private function createNavItem($text, $icon, $link) {
        return "<div class='navigationItem'>
                    <a href='$link'>
                        <img src='$icon'>
                        <span>$text</span>
                    </a>
                </div>";
    }
}
?>