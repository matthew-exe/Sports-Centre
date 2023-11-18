<?php

declare(strict_types=1);

// not too sure about this for now as will need to be indepentent to each event card (ACTUALLY PROBS NOT DUE TO IT BEING ON A SEPERATE PAGE)
function checkBookingErrors() {
    $output = "";
    if (isset($_SESSION["bookingErrors"])) {
        $errors = $_SESSION["bookingErrors"];
        
        foreach ($errors as $error) {
            $output .= "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["bookingErrors"]);
    }
    else if (isset($_GET["booking"]) && $_GET["booking"] === "success") {
        $output .= "<p style='color: green'>Event Booked!</p>";
    }
    return $output;
}



function displayBookings() {
    require_once "booking_model.inc.php";
    require_once "events_model.inc.php";
    require_once "dbh.inc.php";

    $dbh = new dbh();
    $bookings = getUserBookings($dbh->connect(), $_SESSION["userID"]);


    if (0 === 0) { // NOT SURE IF THIS ACTUALLY WORKS TO CHECK IF THERE IS EVENTS
        $counter = 1;
        $output = 'You have not booked any events!';  // temp solution!!!!
        foreach($bookings as $bookings ) {
            $event = getSpecificEvent($dbh->connect(), $bookings["eventID"]);
            if ($counter == 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . $event["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $event["name"] . '</h5>
                <p class="card-text">' . $event["shortDescription"] . '</p>
                <div class="d-flex justify-content-between">
                    <form action="eventinfo.php" method="get">
                        <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                    </form>

                    <form action="includes/cancel_booking.inc.php" method="post">
                        <button type="submit" class="btn btn-primary" name="eventID" id="cancelBooking" value="' . $event["eventID"] . '">Cancel Booking</button>
                    </form>
                </div>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else if ($counter != 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . $event["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $event["name"] . '</h5>
                <p class="card-text">' . $event["shortDescription"] . '</p>
                <div class="d-flex justify-content-between">
                    <form action="eventinfo.php" method="get">
                        <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                    </form>

                    <form action="includes/cancel_booking.inc.php" method="post">
                        <button type="submit" class="btn btn-primary" name="eventID" id="cancelBooking" value="' . $event["eventID"] . '">Cancel Booking</button>
                    </form>
                </div>
                </div>
                </div>
                ';
                $counter++;
            }
            else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="' . htmlspecialchars($event["image"]) . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($event["name"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($event["shortDescription"]) . '</p>
                <div class="d-flex justify-content-between">
                    <form action="eventinfo.php" method="get">
                        <button type="submit" class="btn btn-primary" name="eventID" id="moreInfo" value="' . $event["eventID"] . '">More info</button>
                    </form>

                    <form action="includes/cancel_booking.inc.php" method="post">
                        <button type="submit" class="btn btn-primary" name="eventID" id="cancelBooking" value="' . $event["eventID"] . '">Cancel Booking</button>
                    </form>
                </div>
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
    $dbh = null;
}