<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"]) && $_SESSION["userGroup"] === "Admin") {
    $userID = $_POST ["userID"];
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $originalEmail = $_POST["originalEmail"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";

        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isUpdateDetailsInputEmpty($firstname, $surname, $email)) {
            $errors["emptyInput"] = "No changes inputted!";
        }

        if (!empty($email) && $userController->isEmailInvalid($email)) {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (!empty($email) && $email != $originalEmail && $userController->isEmailRegistered($email)) {
            $errors["emailRegistered"] = "Email is already registered!";
        }

        if ($errors) {
            $_SESSION["editUserDetailsErrors"] = $errors;
            header("Location: ../../edit_user.php?userID=" . $userID);
            foreach ($errors as $error) {
                echo $error;
            }
            die();
        }

        // UPDATING PROFILE INFORMATION IS NEW INFO HAS BEEN PROVIDED

        if (!empty($firstname)) {
            $userController->updateUser("firstname", $firstname, $userID);
        }

        if (!empty($surname)) {
            $userController->updateUser("surname", $surname, $userID);
        }

        if (!empty($email)) {
            $userController->updateUser("email", $email, $userID);
        }

        header("Location: ../../edit_user.php?updateDetails=success&userID=". $userID);

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
