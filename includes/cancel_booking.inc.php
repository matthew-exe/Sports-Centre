<?php

require_once "config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {
    $eventID = $_POST["eventID"];
    try {

    require_once "dbh.inc.php";
    require_once "booking_model.inc.php";

    $dbh = new dbh();
    deleteBooking($dbh->connect(), $_SESSION["userID"], $eventID);
    $dbh = null;

    header("Location: ../profile.php");

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
    else {
    header("Location: ../index.php");
    die();
}
