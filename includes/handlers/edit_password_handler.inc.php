<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["userID"]) && $_SESSION["userGroup"] === "Admin") {
    $userID = $_POST ["userID"];
    $newPwd = $_POST["newPwd"];
    $confirmPwd = $_POST["confirmPwd"];

    try {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/dbh.inc.php";
        require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/controllers/user_controller.inc.php";

        $dbh = new dbh();
        $userController = new UserController($dbh->connect());

        // ERROR HANDLERS
        $errors = [];

        if ($userController->isEditPasswordInputEmpty($newPwd, $confirmPwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        if (!$userController->doPasswordsMatch($newPwd, $confirmPwd)) {
            $errors["emptyInput"] = "Passwords do not match!";
        }

        if (!$userController->isPasswordValid($newPwd)) {
            $errors["emptyInput"] = "Password must be atleast 8 characters and contain atleast one capital letter, one lowercase letter and one number!";
        }

        if ($errors) {
            $_SESSION["editUserPasswordErrors"] = $errors;
            header("Location: ../../edit_user.php?userID=" . $userID);
            foreach ($errors as $error) {
                echo $error;
            }
            die();
        }

        $userController->updatePwd($newPwd, $userID);

        header("Location: ../../edit_user.php?updatePassword=success&userID=". $userID);

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
