<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_POST["userID"];
    try {

    require_once "dbh.inc.php";
    require_once "admin_portal_model.inc.php";

    $dbh = new dbh();
    deleteUserAndRelatedData($dbh->connect(), $userID);
    $dbh = null;

    header("Location: ../admin_portal.php");

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
    else {
    header("Location: ../index.php");
    die();
}
