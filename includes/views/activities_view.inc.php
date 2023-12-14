<?php

function displayActivities($page = 1, $dateFilter = '', $search = '', $filters = []) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/controllers/activity_controller.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/controllers/booking_controller.inc.php";

    $dbh = new dbh();
    $activityController = new ActivityController($dbh->connect());
    $bookingController = new BookingController($dbh->connect());

    // Get total count of job listings based on search and filter
    $totalActivites = $activityController->getTotalActivitiesCount($dateFilter, $search, $filters);


    if (isset($totalActivites)) {
        $perPage = 8; 
        $totalPages = ceil($totalActivites / $perPage);
    } else {

        $totalPages = 0; 
    }

    // Calculate the offset for the SQL query based on current page
    $offset = (intval($page) - 1) * $perPage;

    // Get job listings for the current page based on search and filter
    $activites = $activityController->getActivitiesPaginated($perPage, $offset, $dateFilter, $search, $filters);

    $output = "";
    if ($activites) {
        $counter = 1;
        foreach ($activites as $activity) {
            if ($counter === 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/' . $activity["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $activity["name"] . '</h5>
                <p class="card-text">' . $activity["shortDescription"] . '</p>
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . $activity["activity_id"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }  else if ($counter !== 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/' . $activity["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $activity["name"] . '</h5>
                <p class="card-text">' . $activity["shortDescription"] . '</p>
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . $activity["activity_id"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            } else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/' . $activity["image"] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $activity["name"] . '</h5>
                <p class="card-text">' . $activity["shortDescription"] . '</p>
                <form action="activity_info.php" method="get">
                <button type="submit" class="btn btn-primary" name="activityID" id="moreInfo" value="' . $activity["activity_id"] . '">More info</button>
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
    $bookingController = null;
}