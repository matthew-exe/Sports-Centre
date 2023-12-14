<?php
function checkLoginErrors() {
    if (isset($_SESSION["loginErrors"])) {
        $errors = $_SESSION["loginErrors"];
        
        foreach ($errors as $error) {
            echo "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["loginErrors"]);
    }
    else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<p style='color: green'>Login Successful!</p>";
    }
}