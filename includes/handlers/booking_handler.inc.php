<?php

require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {

    try {
        $activityID = $_POST["activityID"];

        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/controllers/booking_controller.inc.php";

        $dbh = new dbh();
        $bookingController = new BookingController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];
        
        if ($bookingController->isAlreadyBooked($activityID, $_SESSION["userID"])) {
            $errors["alreadyBooked"] = "You have already booked this job listing! Unbook on the profile page!";
        }

        else if ($bookingController->isActivityFull($activityID)) {
            $errors["activityFull"] = "This activity is fully booked!";
        }

        if ($errors) {
            $_SESSION["bookingErrors"] = $errors;

            header("Location: ../../activity_info.php?activityID=$activityID");
            die();
        }

        $bookingController->createBooking($activityID, $_SESSION["userID"]);

        header("Location: ../../activity_info.php?booking=success&activityID=$activityID");

        $dbh = null;
        $bookingController = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../../activities.php");
    die();
}