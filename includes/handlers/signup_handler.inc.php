<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $confirmPwd = $_POST["confirmPwd"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";

        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isSignupInputEmpty($firstname, $surname, $email, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if ($userController->isEmailInvalid($email)) {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if ($userController->isEmailRegistered($email)) {
            $errors["emailRegistered"] = "Email is already registered!";
        }

        if (!$userController->isPasswordValid($pwd)) {
            $errors["invalidPassword"] = "Password must be atleast 8 characters and contain atleast one capital letter, one lowercase letter and one number!";
        }

        if (!$userController->doPasswordsMatch($pwd, $confirmPwd)) {
            $errors["passwordMatch"] = "Passwords do not match!";
        }

        if ($errors) {
            $_SESSION["signupErrors"] = $errors;

            $_SESSION["signupData"] = [
                "firstname" => $firstname,
                "surname" => $surname,
                "email" => $email,
            ];

            header("Location: ../../signup.php");
            $dbh = null;
            $userController = null;
            die();
        }

        // Creating the user and getting the userID of the new user
        $userID = $userController->createUser($firstname, $surname, $email, $pwd);
        // Using that userID to add the user to the Member group
        $userController->setUserGroup($userID, 1);

        header("Location: ../../signup.php?signup=success");

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