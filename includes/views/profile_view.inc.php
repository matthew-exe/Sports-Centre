<?php

function displayProfileData() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/session.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/user_controller.inc.php";

    $dbh = new dbh();
    $UserController = new UserController($dbh->connect());

    $user = $UserController->getUserFromID($_SESSION["userID"]);

    echo '
    <div class="form-group">
    <h4 class="text-center font-weight-bold">Your details:</h4>
    <label for="first-name">First name:</label>
    <input type="text" class="form-control" name="firstname" aria-describeby="firstName" placeholder="'. htmlspecialchars($user["firstname"]) .'">
    </div>
    <div class="form-group">
    <label for="last-name">Surname:</label>
    <input type="text" class="form-control" name="surname" placeholder="'. htmlspecialchars($user["surname"]) .'">
    </div>
    <div class="form-group">
    <label for="email-address">Email Address:</label>
    <input type="text" class="form-control" name="email" placeholder="'. htmlspecialchars($user["email"]) .'">
    </div>
    ';

    $user = null;
    $dbh = null;
    $UserController = null;
}

function displayUsersBookedActivities($page = 1, $dateFilter = '', $search = '') {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/session.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/activity_controller.inc.php";

    $dbh = new dbh();
    $activityController = new activityController($dbh->connect());

    // Get total count of users booked activites based on search and filter
    $totalBookedActivites = $activityController->getTotalUserBookedActivitiesCount($_SESSION["userID"], $dateFilter, $search);

    if (isset($totalBookedActivites)) {
        $perPage = 4; 
        $totalPages = ceil($totalBookedActivites / $perPage);
    } else {
        $totalPages = 0; 
    }

    // Calculate the offset for the SQL query based on current page
    $offset = (intval($page) - 1) * $perPage;

    // Get users booked activties for the current page based on search and filter
    $activites = $activityController->getUserBookedActivitiesPaginated($_SESSION["userID"], $perPage, $offset, $dateFilter, $search);

    $output = "";
    if ($activites) {
        $counter = 1;
        foreach ($activites as $result) {
            if ($counter === 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/' . htmlspecialchars($result["image"]) . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($result["name"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($result["short_description"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . htmlspecialchars($result["activity_id"]) . '">More info</button>
                </form>
                <form action="includes/handlers/cancel_booking_handler.inc.php" method="post" class="mx-3">
                <input type="hidden" name="type" value="event">
                <button type="submit" class="btn btn-danger" name="activityID" id="cancelBooking" value="' . htmlspecialchars($result["activity_id"]) . '">Cancel Booking</button>
                </form>
                </div>
                </div>
                </div>
                ';
                $counter++;
            }  else if ($counter !== 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/' . htmlspecialchars($result["image"]) . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($result["name"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($result["short_description"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . htmlspecialchars($result["activity_id"]) . '">More info</button>
                </form>
                <form action="includes/handlers/cancel_booking_handler.inc.php" method="post" class="mx-3">
                <input type="hidden" name="type" value="event">
                <button type="submit" class="btn btn-danger" name="activityID" id="cancelBooking" value="' . htmlspecialchars($result["activity_id"]) . '">Cancel Booking</button>
                </form>
                </div>
                </div>
                </div>
                ';
                $counter++;
            } else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/' . htmlspecialchars($result["image"]) . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($result["name"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($result["short_description"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . htmlspecialchars($result["activity_id"]) . '">More info</button>
                </form>
                <form action="includes/handlers/cancel_booking_handler.inc.php" method="post" class="mx-3">
                <input type="hidden" name="type" value="event">
                <button type="submit" class="btn btn-danger" name="activityID" id="cancelBooking" value="' . htmlspecialchars($result["activity_id"]) . '">Cancel Booking</button>
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
        if (!empty($output)) {
            $output .= '
            </div>
            </div> ';
            echo $output;
        }
    

        echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $params = http_build_query(array_merge($_GET, ['page' => $i])); 
            if ($i == $page) {
                echo '<li class="page-item active"><a class="page-link" href="?' . $params . '">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?' . $params . '">' . $i . '</a></li>';
            }
        }
        echo '</ul></nav>';
    } else {
        echo '<p>Sorry, there are currently no activities that match your search.</p>';
    }
    

    $dbh = null;
    $activityController = null;
}

function checkUpdateDetailsErrors() {
    if (isset($_SESSION["updateDetailsErrors"])) {
        $errors = $_SESSION["updateDetailsErrors"];
        unset($_SESSION["updateDetailsErrors"]);

    foreach ($errors as $error) {
        echo "<p class='text-danger'>$error</p>";
    }

    }
    else if (isset($_GET["updateDetails"]) && $_GET["updateDetails"] === "success") {
        echo "<p class='ml-4 text-success'>Profile Information Updated!</p>";
    }
}

function checkUpdatePasswordErrors() {
    if (isset($_SESSION["updatePasswordErrors"])) {
        $errors = $_SESSION["updatePasswordErrors"];
        unset($_SESSION["updatePasswordErrors"]);

    foreach ($errors as $error) {
        echo "<p class='text-danger'>$error</p>";
    }

    
    }
    else if (isset($_GET["updatePassword"]) && $_GET["updatePassword"] === "success") {
        echo "<p class='ml-4 text-success'>Password Updated!</p>";
    }
}