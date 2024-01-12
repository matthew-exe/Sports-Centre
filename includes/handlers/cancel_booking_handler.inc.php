<?php

require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userGroup"]) && $_SESSION["userGroup"] === "Admin") {
    $activityID = $_POST["activityID"];
    $userID = $_POST["userID"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/booking_controller.inc.php";

        $dbh = new dbh();
        $bookingController = new BookingController($dbh->connect());
        
        $bookingController->deleteBooking($activityID, $userID);
        
        header("Location: ../../attendees.php?activityID=".$activityID);

        $dbh = null;
        $bookingController = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"]) && $_SESSION["userGroup"] !== "Admin") {
    $activityID = $_POST["activityID"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/booking_controller.inc.php";

        $dbh = new dbh();
        $bookingController = new BookingController($dbh->connect());

        $bookingController->deleteBooking($activityID, $_SESSION["userID"]);

        header("Location: ../../profile.php");

        $dbh = null;
        $bookingController = null;
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
