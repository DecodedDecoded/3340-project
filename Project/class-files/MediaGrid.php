<!-- Class for Media content info: both new & existing media -->
<?php
class MediaGrid {
    // private vars: sql connection, object that contains login session, 
    private $sqlcon, $logged_in_user;
    private $large_mode = false;
    private $grid_class = "media_grid";

    // construct
    public function __construct($sqlcon, $logged_in_user) {
        $this->sqlcon = $sqlcon;
        $this->logged_in_user = $logged_in_user;
    }

    // create the grid for media content
    public function createGridContainer($media, $title, $showFilter, $limit) {

        // if no media array given, generate the HTML layout for new items in the grid
        if($media != null) $grid_content = $this->layoutItems($media);

        // but if media is given, populate the grid with items
        else $grid_content = $this->populateGrid($limit);

        // if grid has a title, create grid header
        if($title != null) {
            $header = $this->setGridTitle($title, $showFilter);
            return "$header
                <div class='$this->grid_class'>
                    $grid_content
                </div>";
        }
        // if not, simply return grid without header
        else {
            return "<div class='$this->grid_class'>
                        $grid_content
                    </div>";
        }
    }

    // retrieve media items from the database
    public function populateGrid($limit) {
        // get array of 'limit' media elements from the database
        $sql_statement = "SELECT * FROM media ORDER BY RAND() LIMIT $limit";
        $sql_qry = $this->sqlcon->query($sql_statement);

        // generate html for media elements in grid
        $html = "";
        while($element = $sql_qry->fetch_assoc()) {
            // create new media object for each media array element
            $media_elem = new Media($this->sqlcon, $this->logged_in_user, $element);

            // create layout for the retrieved media object
            $item = new MediaItem($media_elem, $this->large_mode);

            // add each new element to html
            $html = $html . $item->create();
        }
        return $html;
    }

    // generate layout for grid elements
    public function layoutItems($media) {
        //
        $html ="";

        // create layout for each media item in the media database table
        foreach($media as $item) {
            // create layout for any media to be retrieved
            $item = new MediaItem($item, $this->large_mode);
            $html .= $item->create();
        }

        return $html;
    }

    // create title header over content grid
    public function setGridTitle($title, $showFilter) {
        //
        $filter = "";

        // create html element for header filter
        if($showFilter) {
            $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
            $urlArray = parse_url($link);
            $sql_qry = $urlArray["query"];

            parse_str($sql_qry, $params);
            unset($params["orderBy"]);

            $newQuery = http_build_query($params);

            $newUrl = basename($_SERVER["PHP_SELF"]) . "?" . $newQuery;
            
            $filter = "<div class='right'>
                            <span>|                     Order by:</span>
                            <a href='$newUrl&orderBy=uploadDate'>Upload Date</a>
                            <a href='$newUrl&orderBy=views'>Most Viewed</a>

                        </div>";
        }

        // return html element of title header
        return "<div class='grid_header'>
                    <div class='left'>
                        $title
                    </div>
                    $filter
                </div>";
    }

    public function createLarge($media, $title, $showFilter) {
        $this->grid_class .= " large";
        $this->large_mode = true;
        return $this->createGridContainer($media, $title, $showFilter, 100);
    }
}

?>