<?php

// FILE USED TO SHOW EVERYTHING

declare(strict_types=1); // makes variables have a type

function signupInputs() {
    // this function will fill in the signup form so it holds the user data, it will not hold if the signup was successful

    if (isset($_SESSION["signupData"]["firstname"]) && !isset($_GET["signup"])) {
        echo '<input type="text"name="firstname" placeholder="Firstname" value="' . $_SESSION["signupData"]["firstname"] . '"><br>';
    } 
    else {
        echo '<input type="text"name="firstname" placeholder="Firstname" ><br>';
    }

    if (isset($_SESSION["signupData"]["surname"]) && !isset($_GET["signup"])) {
        echo '<input type="text"name="surname" placeholder="Surname" value="' . $_SESSION["signupData"]["surname"] . '"><br>';
    } 
    else {
        echo '<input type="text"name="surname" placeholder="Surname" ><br>';
    }

    if (isset($_SESSION["signupData"]["email"]) && !isset($_SESSION["signupErrors"]["emailRegistered"]) && !isset($_SESSION["signupErrors"]["invalidEmail"])  && !isset($_GET["signup"])) {
        echo '<input type="text"name="email" placeholder="Email" value="' . $_SESSION["signupData"]["email"] . '"><br>';
    } 
    else {
        echo '<input type="text"name="email" placeholder="Email" ><br>';
    }

    echo '<input type="password" name="pwd" placeholder="Password" ><br><br>';

    unset($_SESSION["signupData"]);
}

function checkSignupErrors() {
    if (isset($_SESSION["signupErrors"])) {
        $errors = $_SESSION["signupErrors"];

    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }

    unset($_SESSION["signupErrors"]);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<p>Sign Up Successful!</p>";
    }
}

