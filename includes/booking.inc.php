<?php

require_once "config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {

    try {
        $eventID = intval($_POST["eventID"]); // getting int val need to change later!!!!

        require_once "dbh.inc.php";
        require_once "booking_model.inc.php";
        require_once "booking_controller.inc.php";

        $dbh = new dbh();

        // ERROR HANDLERS
        $errors = [];


        if (isAlreadyBooked($dbh->connect(), $_SESSION["userID"], $eventID)) {
            $errors["alreadyBooked"] = "You have already booked this event! Cancel booking on profile page!";
        }

        if (isEventFull($dbh->connect(), $eventID)) {
            $errors["eventFull"] = "The event is full!";
            echo "The event is full!";
        }



        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["bookingErrors"] = $errors;

            header("Location: ../eventinfo.php?eventID=$eventID");
            
            die();
        }

        createBooking($dbh->connect(), $_SESSION["userID"], $eventID);
        

        header("Location: ../eventinfo.php?booking=success&eventID=$eventID");

        $dbh = null;
        $statement = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../events.php");
    die();
}
