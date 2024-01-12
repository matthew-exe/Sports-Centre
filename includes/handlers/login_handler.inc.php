<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";

        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        $user = $userController->getUserFromEmail($email);

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isLoginInputEmpty($email, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if (!$userController->isEmailRegistered($email)) {
            $errors["incorrectEmail"] = "Incorrect email!";
        }


        if ($userController->isEmailRegistered($email) && !$userController->isPasswordCorrect($pwd, $user["pwd"])) {
            $errors["incorrectPassword"] = "Incorrect password!";
        }
        

        if ($errors) {
            $_SESSION["loginErrors"] = $errors;

            header("Location: ../../login.php");
            die();
        }

        
        // Starting session and setting regenerating time
        session_start();
        $_SESSION["lastRegeneration"] = time();

        // Setting userID and userGroup to authorise access
        $_SESSION["userID"] = $user["user_id"];
        $_SESSION["userGroup"] = $userController->getUserGroup($user["user_id"]);
        
        header("Location: ../../login.php?login=success");

        $user = null;
        $statement = null;
        $dbh = null;
        die();
    }
    catch (PDOException $e) {
        die("Quesry failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../../error.php");
    die();
}