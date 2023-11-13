<?php 

require_once "config_session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {
    try {
        $newPassword = $_POST["newPassword"];
        $currentPassword = $_POST["currentPassword"];
        $confirmPassword = $_POST["confirmPassword"];
        
        require_once "dbh.inc.php";
        require_once "profile_model.inc.php"; 
        require_once "profile_controller.inc.php"; 

        $dbh = new dbh();
        $result = getUser($dbh->connect(), $_SESSION["userID"]);

        // ERROR HANDLERS
        $errors = [];

        if (isPasswordInputsEmpty($newPassword, $currentPassword, $confirmPassword)) {
            $errors["inputEmpty"] = "Please fill in all the fields!";
        }

        if (isPasswordWrong($currentPassword, $result["pwd"])) {
            $errors["invalidPassword"] = "Incorrect password!";
        }

        if (!isPasswordTheSame($newPassword, $confirmPassword)) {
            $errors["confirmPassword"] = "New password does not match confirmed password!";
        }


        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["updatePasswordErrors"] = $errors;
            header("Location: ../profile.php");
            die();
        }

        require_once "profile_model.inc.php";


        updatePassword($dbh->connect(), $_SESSION["userID"], $newPassword);


        header("Location: ../profile.php?updatePassword=success");

        $result = null;
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
