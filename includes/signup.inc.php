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

        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($firstname, $surname, $email, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if (isEmailInvalid($email)) {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (isEmailRegistered($pdo, $email)) {
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

        createUser($pdo, $firstname, $surname, $email, $pwd);


        header("Location: ../signup.php?signup=success");

        $pdo = null;
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
