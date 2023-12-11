<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "../configs/dbh.inc.php";
        require_once "../configs/session.inc.php";
        require_once "../controllers/user_controller.inc.php";

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

        if ($userController->isPasswordValid($pwd)) {
            $errors["invalidPassword"] = "Password must contain atleast one capital letter, one number and one symbol!";
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