<?php
function displayExpandedActivity($activityID) {


    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/controllers/activity_controller.inc.php";

    $dbh = new dbh();
    $ActivityController = new ActivityController($dbh->connect());

    $activity = $ActivityController->getActivityById($activityID);

    // Handling if the last page url is not already set
    if (!isset($_SESSION['last_page_url'])) {
        $_SESSION['last_page_url'] = "activities.php";
    }
    

    $output = '
    <div class="container mt-5 justify-content-center" style="max-width: 500px;">
        <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
            <div>
                <a href="'. $_SESSION['last_page_url'] .'" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>
            </div>
            <h1 class="mb-1"><strong>' . $activity["name"] . '</strong></h1>
            <p class="mb-2"><strong>Hosted by:</strong> ' . $activity["host"] . '</p>
            <p class="mb-1"><strong>Description: </strong></p>
            <p class="mb-2">' . $activity["longDescription"] . '</p>
            <p class="mb-2"><strong>Capacity:</strong> ' . $activity["capacity"] . '</p>
            <p class="mb-1"><strong>Time:</strong> ' . date("H:i", strtotime($activity["activity_time"])) . '</p>
            <p class="mb-2"><strong>Date:</strong> ' . date("d/m/Y", strtotime($activity["activity_time"])) . '</p>
            ' . "booking errors here" . '';
            
            if (isset($_SESSION["userID"])) {
                $output .= '
                <form action="includes/booking.inc.php" method="post">
                <button type="submit" class="btn btn-primary mb-2" name="activityID" id="moreInfo" value="' . $activityID . '">Book Event</button>
                </form>
                ';
            } else {
                $output .= '<p style="color: red">Please log in to book this activity.</p>';
            }
            
            $output .= '
            </div>
    </div>
    ';
    
    echo $output;

    $ActivityController = null;
    $dbh = null;
}