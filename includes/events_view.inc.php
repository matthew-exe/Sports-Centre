<?php 

declare(strict_types=1);

function displayEvents() {
    require_once "dbh.inc.php";
    require_once "events_model.inc.php";

    $dbh = new dbh();
    $events = getEvents($dbh->connect());
    $dbh = null;

    if ($events > 0) { // NOT SURE IF THIS ACTUALLY WORKS TO CHECK IF THERE IS EVENTS
        $counter = 1;
        $output = 'There are no events currently!';  // temp solution!!!!
        foreach($events as $event ) {
            if ($counter == 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="width: 18rem;">
                <img src="' . $event["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $event["name"] . '</h5>
                <p class="card-text">' . $event["description"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else if ($counter != 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="width: 18rem;">
                <img src="' . $event["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $event["name"] . '</h5>
                <p class="card-text">' . $event["description"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="width: 18rem;">
                <img src="' . $event["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $event["name"] . '</h5>
                <p class="card-text">' . $event["description"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                </form>
                </div>
                </div>
                </div>
                </div> 
                ';
                $counter = 1;
                echo $output;
                $output = '';
            }
        }
        if ($output != '') { 
            echo $output;
        }
    }
}