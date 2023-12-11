<?php


function displayProfileData() {
    require_once "C:/xampp/htdocs/Web-Programming/includes/configs/session.inc.php";
    require_once "C:/xampp/htdocs/Web-Programming/includes/configs/dbh.inc.php";
    require_once "C:/xampp/htdocs/Web-Programming/includes/controllers/user_controller.inc.php";

    $dbh = new dbh();
    $userController = new UserController($dbh->connect());

    $user = $userController->getUserFromID($_SESSION["userID"]);

    echo '
    <div class="form-group">
    <h4 class="text-center font-weight-bold">Your details:</h4>
    <label for="first-name">First name:</label>
    <input type="text" class="form-control" name="firstname" aria-describeby="firstName" placeholder="'. htmlspecialchars($user["firstname"]) .'">
    </div>
    <div class="form-group">
    <label for="last-name">Surname:</label>
    <input type="text" class="form-control" name="surname" placeholder="'. htmlspecialchars($user["surname"]) .'">
    </div>
    <div class="form-group">
    <label for="email-address">Email Address:</label>
    <input type="text" class="form-control" name="email" placeholder="'. htmlspecialchars($user["email"]) .'">
    </div>
    ';

    $user = null;
    $dbh = null;
    $userController = null;
}

function checkUpdateDetailsErrors() {
    if (isset($_SESSION["updateDetailsErrors"])) {
        $errors = $_SESSION["updateDetailsErrors"];
        unset($_SESSION["updateDetailsErrors"]);

    foreach ($errors as $error) {
        echo "<p style='color: red'>$error</p>";
    }

    }
    else if (isset($_GET["detailsUpdate"]) && $_GET["updateDetails"] === "success") {
        echo "<p style='color: green'>Profile Information Updated!</p>";
    }
}

function checkUpdatePasswordErrors() {
    if (isset($_SESSION["updatePasswordErrors"])) {
        $errors = $_SESSION["updatePasswordErrors"];
        unset($_SESSION["updatePasswordErrors"]);

    foreach ($errors as $error) {
        echo "<p style='color: red'>$error</p>";
    }

    
    }
    else if (isset($_GET["updatePassword"]) && $_GET["updatePassword"] === "success") {
        echo "<p style='color: green'>Password Updated!</p>";
    }
}