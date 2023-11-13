<?php



function profileData() {
    require_once "profile_model.inc.php";
    require_once "dbh.inc.php";
    $dbh = new dbh();
    $userData = getUser($dbh->connect(), $_SESSION["userID"]);
    $dbh = null;

    // echo '<input type="text" name="firstname" placeholder="Firstname: ' . htmlspecialchars($userData["firstname"]) . '" ><br>';
    // echo '<input type="text" name="surname" placeholder="Surname: ' . htmlspecialchars($userData["surname"]) . '" ><br>';
    // echo '<input type="text" name="email" placeholder="Email: ' . htmlspecialchars($userData["email"]) . '" ><br>';
    // echo '<input type="text" name="pwd" placeholder="Password: *************" ><br><br>';

    echo '
    <div class="form-group">
    <h4 class="text-center font-weight-bold">Your details:</h4>
    <label for="first-name">First name:</label>
    <input type="text" class="form-control" name="firstname" aria-describeby="firstName" placeholder="'. htmlspecialchars($userData["firstname"]) .'">
    </div>
    <div class="form-group">
    <label for="last-name">Surname:</label>
    <input type="text" class="form-control" name="surname" placeholder="'. htmlspecialchars($userData["surname"]) .'">
    </div>
    <div class="form-group">
    <label for="email-address">Email Address:</label>
    <input type="text" class="form-control" name="email" placeholder="'. htmlspecialchars($userData["email"]) .'">
    </div>
    ';

    $userData = null;
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