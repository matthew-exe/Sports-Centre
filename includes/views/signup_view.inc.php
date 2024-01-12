<?php

function checkSignupErrors() {
    if (isset($_SESSION["signupErrors"])) {
        $errors = $_SESSION["signupErrors"];

    foreach ($errors as $error) {
        echo "<p class='text-danger'>$error</p>";
    }

    unset($_SESSION["signupErrors"]);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<p class='ml-4 text-success'>Sign Up Successful!</p>";
    }
}

function displaySignupInputs() {
    if (isset($_SESSION["signupData"]["firstname"]) && !isset($_GET["signup"])) {
        echo '
        <div class="form-group">
            <h4 class="text-center font-weight-bold">Signup</h4>
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control mb-2" name="firstname" placeholder="Enter firstname" required value="' . $_SESSION["signupData"]["firstname"] . '">
        </div>
        ';
    } 
    else {
        echo '
        <div class="form-group">
            <h4 class="text-center font-weight-bold">Signup</h4>
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control mb-2" name="firstname" placeholder="Enter firstname" required>
        </div>
        ';
    }

    if (isset($_SESSION["signupData"]["surname"]) && !isset($_GET["signup"])) {
        echo '
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control mb-2" name="surname" placeholder="Enter surname" required value="' . $_SESSION["signupData"]["surname"] . '">
        </div>
        ';
    } 
    else {
        echo '
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control mb-2" name="surname" placeholder="Enter surname" required>
        </div>
        ';
    }

    if (isset($_SESSION["signupData"]["email"]) && !isset($_SESSION["signupErrors"]["emailRegistered"]) && !isset($_SESSION["signupErrors"]["invalidEmail"])  && !isset($_GET["signup"])) {
        echo '
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control mb-2" name="email" placeholder="Enter email" required value="' . $_SESSION["signupData"]["email"] . '">
        </div>
        ';
    } 
    else {
        echo '
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control mb-2" name="email" placeholder="Enter email" required>
        </div>
        ';
    }

    echo '
    <div class="form-group">
        <label for="pwd">Password</label>
        <input type="password" class="form-control mb-2" name="pwd" placeholder="Password" required>
    </div>
    <div class="form-group">
        <label for="pwd">Confirm Password</label>
        <input type="password" class="form-control mb-4" name="confirmPwd" placeholder="Confirm Password" required>
    </div>
    ';

    unset($_SESSION["signupData"]);
}

