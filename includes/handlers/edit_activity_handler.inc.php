<?php

require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userGroup"]) && $_SESSION["userGroup"] === "Admin") {
    $activityID = $_POST["activityID"];
    $activityName = $_POST["activityName"];
    $shortDescription = $_POST["shortDescription"];
    $longDescription = $_POST["longDescription"];
    $activityHost = $_POST["activityHost"];
    $activityImage = $_POST["activityImage"];
    $activityCapacity = $_POST["activityCapacity"];
    $activityTime = $_POST["activityTime"];
    $activityDate = $_POST["activityDate"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/activity_controller.inc.php";

        $dbh = new dbh();
        $activityController = new ActivityController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];

        if ($activityController->isActivityInputEmpty($activityName, $shortDescription, $longDescription, $activityHost, $activityImage, $activityCapacity, $activityTime, $activityDate)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if ($activityController->isCapacityNumber($activityCapacity)) {
            $errors["capacityNumber"] = "The capacity must be a number!";
        }

        if ($errors) {
            $_SESSION["activityUpdateErrors"] = $errors;
            header("Location: ../../edit_activity.php?activityID=". $activityID);
            die();
        }

        $activityController->updateActivity($activityID, $activityName, $shortDescription, $longDescription, $activityHost, $activityImage, $activityCapacity, $activityTime, $activityDate);

        header("Location: ../../edit_activity.php?update=success&activityID=". $activityID);

        $dbh = null;
        $activityController = null;
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../error.php");
    die();
}