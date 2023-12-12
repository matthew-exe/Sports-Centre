<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/controllers/user_controller.inc.php";
        
        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isUpdateDetailsInputEmpty($firstname, $surname, $email)) {
            $errors["emptyInput"] = "No changeds inputted!";
        }

        if (!empty($email) && $userController->isEmailInvalid($email)) {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (!empty($email) && $userController->isEmailRegistered($email)) {
            $errors["emailRegistered"] = "Email is already registered!";
        }

        if ($errors) {
            $_SESSION["updateDetailsErrors"] = $errors;
            header("Location: ../../profile.php");
            die();
        }

        // UPDATING PROFILE INFORMATION IS NEW INFO HAS BEEN PROVIDED
        
        if (!empty($firstname)) {
            $userController->updateUser("firstname", $firstname, $_SESSION["userID"]);
        }

        if (!empty($surname)) {
            $userController->updateUser("surname", $surname, $_SESSION["userID"]);
        }

        if (!empty($email)) {
            $userController->updateUser("email", $email, $_SESSION["userID"]);
        }

        header("Location: ../../profile.php?updateDetails=success");

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
