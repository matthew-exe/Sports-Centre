<?php
function displayExpandedActivity($activityID) {


    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/activity_controller.inc.php";

    $dbh = new dbh();
    $activityController = new ActivityController($dbh->connect());

    $activity = $activityController->getActivityById($activityID);

    // Handling if the last page url is not already set
    if (!isset($_SESSION['last_page_url'])) {
        $_SESSION['last_page_url'] = "activities.php";
    }
    
    if ($activity) {
        $output = '
        <div class="container mt-5 justify-content-center" style="max-width: 500px;">
            <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
                <div>
                    <a href="' . $_SESSION['last_page_url'] . '" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>
                </div>
                <h1 class="mb-1"><strong>' . htmlspecialchars($activity["name"]) . '</strong></h1>
                <p class="mb-2"><strong>Hosted by:</strong> ' . htmlspecialchars($activity["host"]) . '</p>
                <p class="mb-1"><strong>Description: </strong></p>
                <p class="mb-2">' . htmlspecialchars($activity["long_description"]) . '</p>
                <p class="mb-2"><strong>Capacity:</strong> ' . $activityController->countBookingsForActivity($activityID) . '/' . $activity["capacity"] . '</p>
                <p class="mb-1"><strong>Time:</strong> ' . date("H:i", strtotime(htmlspecialchars($activity["activity_time"]))) . '</p>
                <p class="mb-2"><strong>Date:</strong> ' . date("d/m/Y", strtotime(htmlspecialchars($activity["activity_date"]))) . '</p>
                ' . checkBookingErrors() . '';

        if (isset($_SESSION["userID"]) && $_SESSION["userGroup"] == "Admin") {
            $output .= '
                    <div class="container">
                        <div class="d-flex justify-content-start">
                            <form action="edit_activity.php" method="get">
                                <button type="submit" class="btn btn-primary mb-2" name="activityID" id="editActivity" value="' . htmlspecialchars($activityID) . '">Edit Activity</button>
                            </form>
                            <form action="attendees.php" method="get" class="mx-3">
                                <button type="submit" class="btn btn-primary mb-2" name="activityID" id="viewAttendees" value="' . htmlspecialchars($activityID) . '">View Attendees</button>
                            </form>
                            <form action="includes/handlers/delete_activity_handler.inc.php" method="post">
                                <button type="submit" class="btn btn-danger mb-2" name="activityID" id="deleteActivity" value="' . htmlspecialchars($activityID) . '">Delete Activity</button>
                            </form>
                        </div>
                    </div>
                    ';
        } elseif (isset($_SESSION["userID"])) {
            $output .= '
                    <form action="includes/handlers/booking_handler.inc.php" method="post">
                    <button type="submit" class="btn btn-primary mb-2" name="activityID" id="moreInfo" value="' . htmlspecialchars($activityID) . '">Book Event</button>
                    </form>
                    ';
        } else {
            $output .= '<p class="text-danger">Please log in to book this event.</p>';
        }

        $output .= '
                </div>
        </div>
        ';

        echo $output;
    }

    $activityController = null;
    $dbh = null;
}

function checkBookingErrors() {
    $output = "";

    if (isset($_SESSION["bookingErrors"])) {
        $errors = $_SESSION["bookingErrors"];
        
        foreach ($errors as $error) {
            $output .= "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["bookingErrors"]);
    }
    else if (isset($_GET["booking"]) && $_GET["booking"] === "success") {
        $output .= "<p class='ml-4 text-success'>Activity Booked!</p>";
    }
    return $output;
}