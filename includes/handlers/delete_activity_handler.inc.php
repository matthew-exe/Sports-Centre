<?php

require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userGroup"]) && $_SESSION["userGroup"] === "Admin") {
    $activityID = $_POST["activityID"]; 

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/controllers/activity_controller.inc.php";

        $dbh = new dbh();
        $activityController = new ActivityController($dbh->connect());

        $activityController->deleteActivity($activityID);
        
        // Handling if the last page url is not already set
        if (!isset($_SESSION['last_page_url'])) {
            $location = "Location: ../../activities.php";
        }
        else {
            $location = "Location: ".$_SESSION['last_page_url'];
        }
                
        header($location);

        $dbh = null;
        $activityController = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../../error.php");
    die();
}