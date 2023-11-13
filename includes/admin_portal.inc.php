<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventName = $_POST["eventName"];
    $eventDescription = $_POST["eventDescription"];
    $eventHost = $_POST["eventHost"];
    $eventImage = $_POST["eventImage"];
    $eventCapacity = $_POST["eventCapacity"];
    $eventTime = $_POST["eventTime"];
    $eventDate = $_POST["eventDate"];

    try {
        require_once "dbh.inc.php";
        require_once "admin_portal_model.inc.php";
        require_once "admin_portal_controller.inc.php";


        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($eventName, $eventDescription, $eventHost, $eventImage, $eventCapacity, $eventTime, $eventDate)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["eventCreationErrors"] = $errors;

            $eventData = [
                "name" => $eventName,
                "description" => $eventDescription,
                "host" => $eventHost,
                "image" => $eventImage,
                "capacity" => $eventCapacity,
                "eventTime" => $eventTime,
                "eventDate" => $eventDate
            ];

            $_SESSION["eventData"] = $eventData;

            header("Location: ../admin_portal.php");
            die();
        }

        $dbh = new dbh();

        createEvent($dbh->connect(), $eventName, $eventDescription, $eventHost, $eventImage, $eventCapacity, $eventTime, $eventDate);

        header("Location: ../admin_portal.php?eventCreation=success");

        $dbh = null;
        $statement = null;
        die();



    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }


} else {
    header("Location: ../index.php");
    die();
}