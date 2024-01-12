<?php
function checkLoginErrors() {
    if (isset($_SESSION["loginErrors"])) {
        $errors = $_SESSION["loginErrors"];
        
        foreach ($errors as $error) {
            echo "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["loginErrors"]);
    }
    else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<p class='ml-4 text-success'>Login Successful!</p>";
    }
}