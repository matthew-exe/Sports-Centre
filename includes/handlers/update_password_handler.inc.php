<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"])) {
    $pwd = $_POST["pwd"];
    $newPwd = $_POST["newPwd"];
    $confirmPwd = $_POST["confirmPwd"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/controllers/user_controller.inc.php";
        
        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        $user = $userController->getUserFromID($_SESSION["userID"]);

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isUpdatePasswordInputEmpty($pwd, $newPwd, $confirmPwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if (!$userController->isPasswordCorrect($pwd, $user["pwd"])) {
            $errors["emptyInput"] = "Incorrect password!";
        }

        if (!$userController->doPasswordsMatch($newPwd, $confirmPwd)) {
            $errors["emptyInput"] = "Passwords do not match!";
        }
 
        if (!$userController->isPasswordValid($newPwd)) {
            $errors["emptyInput"] = "Password must be atleast 8 characters and contain atleast one capital letter, one lowercase letter and one number!";
        }

        if ($errors) {
            $_SESSION["updatePasswordErrors"] = $errors;
            header("Location: ../../profile.php");
            die();
        }
        
        $userController->updatePwd($newPwd, $_SESSION["userID"]);

        header("Location: ../../profile.php?updatePassword=success");

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