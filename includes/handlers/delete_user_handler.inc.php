<?php

require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userGroup"]) && $_SESSION["userGroup"] === "Admin" && $_SESSION["userID"] != $_POST["userID"]) {

    try {
        $userID = $_POST["userID"];
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";


        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        $userController->deleteUser($userID);

        header("Location: ../../admin_portal.php");

        $dbh = null;
        $userController = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"]) && $_SESSION["userGroup"] !== "Admin") {
    try {
        $userID = $_POST["userID"];
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";

        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        $userController->deleteUser($userID);
        unset($_SESSION["userID"]);
        unset($_SESSION["userGroup"]);

        header("Location: ../../index.php");

        $dbh = null;
        $userController = null;
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