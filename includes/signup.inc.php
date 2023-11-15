<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_controller.inc.php";

        $dbh = new dbh();

        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($firstname, $surname, $email, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if (isEmailInvalid($email)) {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (isEmailRegistered($dbh->connect(), $email)) {
            $errors["emailRegistered"] = "Email is already registered!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["signupErrors"] = $errors;

            $signupData = [
                "firstname" => $firstname,
                "surname" => $surname,
                "email" => $email,
            ];

            $_SESSION["signupData"] = $signupData;

            header("Location: ../signup.php");
            die();
        }

        createUser($dbh->connect(), $firstname, $surname, $email, $pwd);
        setGroup($dbh->connect(), getUserID($dbh->connect(), $email)); // probs should change this to go to the controller first!!!!!!

        header("Location: ../signup.php?signup=success");

        $dbh = null;
        $statement = null;
        die();

    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../index.php");
    die();
}
