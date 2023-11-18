<?php

declare(strict_types=1);

function displayExpandedEvent(int $eventID) {

    require_once "dbh.inc.php";
    require_once "events_model.inc.php";
    require_once "booking_view.inc.php";

    $dbh = new dbh();
    $event = getSpecificEvent($dbh->connect(), $eventID);
    $dbh = null;

    $output = '
    <div class="container justify-content-center">
        <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
            <div class="col-sm-7">
            <h1 class="mt-3 mb-1">' . $event["name"] . '</h1>
            <p class="mb-3">Hosted by: ' . $event["host"] . '</p>
            <p class="mb-4">' . $event["longDescription"] . '</p>
            <p class="mb-4">Capacity: ' . $event["capacity"] . '</p>
            <p class="mb-2">Time: ' . date("H:i", strtotime($event["eventTime"])) . '</p>
            <p class="mb-4">Date: ' . date("d/m/Y", strtotime($event["eventDate"])) . '</p>
            ' . checkBookingErrors() . '';
            
            if (isset($_SESSION["userID"])) {
                $output .= '
                <form action="includes/booking.inc.php" method="post">
                <button type="submit" class="btn btn-primary mb-2" name="eventID" id="moreInfo" value="' . $eventID . '">Book Event</button>
                </form>
                ';
            } else {
                $output .= '<p style="color: red">Please log in to book this event.</p>';
            }
            
            $output .= '
            </div>
            <div class="col-sm-5 align-self-center justify-content-end">
            <img src="' . $event["image"] . '"style="max-width: 18rem;">
            </div>
            </div>
    </div>
    ';
    
    echo $output;
}
