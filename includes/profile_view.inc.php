<?php



function profileData() {

    require_once "dbh.inc.php";
    require_once "profile_model.inc.php";
    $userData = getUser($pdo, $_SESSION["userId"]);

    echo '<input type="text" name="firstname" placeholder="Firstname: ' . htmlspecialchars($userData["firstname"]) . '" ><br>';
    echo '<input type="text" name="surname" placeholder="Surname: ' . htmlspecialchars($userData["surname"]) . '" ><br>';
    echo '<input type="text" name="email" placeholder="Email: ' . htmlspecialchars($userData["email"]) . '" ><br>';
    echo '<input type="text" name="pwd" placeholder="Password: *************" ><br><br>';

    $userData = null;
}

function checkProfileEditErrors() {
    if (isset($_SESSION["profileEditErrors"])) {
        $errors = $_SESSION["profileEditErrors"];

    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }

    unset($_SESSION["profileEditErrors"]);
    }
    else if (isset($_GET["edit"]) && $_GET["edit"] === "success") {
        echo "<p>Profile Information Updated!</p>";
    }
}