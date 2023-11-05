<?php 

require_once "config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userId"])) {
    try {
        $firstname = $_POST["firstname"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];

        require_once "dbh.inc.php";
        require_once "signup_model.inc.php"; // using sign up to not repeat code
        require_once "signup_controller.inc.php"; // using sign up to not repeat code

        // ERROR HANDLERS
        $errors = [];

        if (isEmailInvalid($email) && $email != "") {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (isEmailRegistered($pdo, $email) && $email != "") {
            $errors["emailRegistered"] = "The new email is already registered!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["profileEditErrors"] = $errors;
            header("Location: ../profile.php");
            die();
        }

        require_once "profile_model.inc.php";

        if ($firstname != "") {
            updateFirstname($pdo, $_SESSION["userId"], $firstname);
        }

        if ($surname != "") {
            updateSurname($pdo, $_SESSION["userId"], $surname);
        }

        if ($email != "") {
            updateEmail($pdo, $_SESSION["userId"], $email);
        }

        if ($pwd != "") {
            updatePassword($pdo, $_SESSION["userId"], $pwd);
        }


        header("Location: ../profile.php?edit=success");

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
