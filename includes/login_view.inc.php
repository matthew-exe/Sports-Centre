<?php 

declare(strict_types=1);

function checkLoginErrors() {
    if (isset($_SESSION["loginErrors"])) {
        $errors = $_SESSION["loginErrors"];
        
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }

        unset($_SESSION["loginErrors"]);
    }
    else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<p>Login Successful!</p>";
    }
}

function showUsername() {
    if (isset($_SESSION["userId"])) {
        echo "You are logged in as " . $_SESSION["userEmail"];
    }
    else {
        echo "You are not logged in";
    }
}

