<?php

declare(strict_types=1);

function displaySearchedEvents(?string $searchInput, ?string $dateFilter, ?array $filters) {

    require_once "dbh.inc.php";
    require_once "search_model.inc.php";
    require_once "booking_model.inc.php";

    $dbh = new dbh();
    if ($searchInput != "" && $dateFilter != "") {
        $searchResult = searchEventsFilterDate($dbh->connect(), $searchInput, $dateFilter);
    }
    elseif ($dateFilter != "") {
        $searchResult = searchFilterDate($dbh->connect(), $dateFilter);
    }
    elseif ($searchInput != "" && isset($filters) && in_array("closestdate", $filters)) {
        $searchResult = searchEventsSortByDate($dbh->connect(), $searchInput);
    }
    elseif (isset($filters) && in_array("closestdate", $filters)) {
        $searchResult = searchSortByDate($dbh->connect());
    }
    else {
        $searchResult = searchEvents($dbh->connect(), $searchInput);
    }

    
    

    if ($searchResult > 0) { // NOT SURE IF THIS ACTUALLY WORKS TO CHECK IF THERE IS EVENTS
        $counter = 1;
        $output = 'There was no search results!'; // temp solution!!!!
        foreach ($searchResult as $result) {
            if (isset($filters) && in_array("notfullybooked", $filters) && $result["capacity"] <= sizeof(getBookings($dbh->connect(), strval($result["eventID"])))) {
                continue;
            }
            if ($counter ==1) {
                $output = '
                <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . $result["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["name"] . '</h5>
                <p class="card-text">' . $result["shortDescription"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $result["eventID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }  else if ($counter != 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . $result["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["name"] . '</h5>
                <p class="card-text">' . $result["shortDescription"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $result["eventID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            } else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . $result["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["name"] . '</h5>
                <p class="card-text">' . $result["shortDescription"] . '</p>
                <form action="eventinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $result["eventID"] . '">More info</button>
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
    unset($_SESSION["searchInput"]);
    $dbh = null;
}