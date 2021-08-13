<!-- -->
<?php
class MediaItem {

    private $video, $largeMode;

    public function __construct($video, $largeMode) {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }

    public function create() {
        // create thumbnail
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $url = "view.php?id=" . $this->video->getId();

        return "<a href='$url'>
                    <div class='videoGridItem'>
                    $thumbnail
                    $details
                    </div>
                </a>";
    }

    private function createThumbnail() {
       $thumbnail = $this->video->getThumbnail();

       return "<div class='thumbnail'>
                    <img src='$thumbnail' width='210' height='118'>
                </div>";
    }
    private function createDetails() {
        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $views = $this->video->getViews();
        $description = $this->createDescription();
        $timeStamp = $this->video->getUploadDate();

        return "<div class='details'>
                    <h3 class='title'>$title</h3>
                    <span class='username'>$username</span>
                    <div class='stats'>
                        <span class='viewCount'>$views views</span>
                        <span class='timeStamp'>$timeStamp</span>
                    </div>
                    $description
                </div>";
    }

    private function createDescription() {
        if(!$this->largeMode) {
            return "";
        }
        else {
            $description = $this->video->getDescription();
            $description = (strlen($description) > 350) ? substr($description, 0, 347) . "..." : $description;
            return "<span class='description'>$description</span>";
        }
    }
}
?>