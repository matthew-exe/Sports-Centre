<?php 

require_once "config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {
    try {
        $firstname = $_POST["firstname"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        
        require_once "dbh.inc.php";
        require_once "profile_controller.inc.php";
        require_once "signup_model.inc.php"; // using sign up to not repeat code
        require_once "signup_controller.inc.php"; // using sign up to not repeat code

        $dbh = new dbh();

        // ERROR HANDLERS
        $errors = [];

        if (isAllDetailsInputsEmpty($firstname, $surname, $email)) {
            $errors["invalidEmail"] = "No changes have been inputed!";
        }

        if (isEmailInvalid($email) && $email != "") {
            $errors["invalidEmail"] = "Invalid email!";
        }

        if (isEmailRegistered($dbh->connect(), $email) && $email != "") {
            $errors["emailRegistered"] = "The new email is already registered!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["updateDetailsErrors"] = $errors;
            header("Location: ../profile.php");
            die();
        }

        require_once "profile_model.inc.php";

        if ($firstname != "") {
            updateFirstname($dbh->connect(), $_SESSION["userID"], $firstname);
        }

        if ($surname != "") {
            updateSurname($dbh->connect(), $_SESSION["userID"], $surname);
        }

        if ($email != "") {
            updateEmail($dbh->connect(), $_SESSION["userID"], $email);
        }



        header("Location: ../profile.php?updateDetails=success");

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
