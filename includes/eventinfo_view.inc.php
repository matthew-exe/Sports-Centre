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
    <div class="container">
        <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
            <div class="col-sm-7">
                <div>
                    <h1 class="mt-3 mb-1">' . $event["name"] . '</h1>
                    <p class="mb-3">Hosted by: ' . $event["host"] . '</p>
                    <p class="mb-4">' . $event["description"] . '</p>
                    <p class="mb-4">Capacity: ' . $event["capacity"] . '</p>
                    <p class="mb-2">Time: ' . $event["eventTime"] . '</p>
                    <p class="mb-4">Date: ' . $event["eventDate"] . '</p>
                    ' . checkBookingErrors() . '';

    if (isset($_SESSION["userID"])) {
        $output .= '
                    <form action="includes/booking.inc.php" method="post">
                        <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $eventID . '">Book Event</button>
                    </form>
        ';
    } else {
        $output .= '<p style="color: red">Please log in to book this event.</p>';
    }

    $output .= '
                </div>
            </div>
            <div class="col-sm-5"><img src="' . $event["image"] . '" class="img-fluid"></div>
        </div>
    </div>
    ';

    echo $output;
}
