<?php
require_once "includes/signup_view.inc.php";
require_once "includes/login_view.inc.php";
require_once "includes/config_session.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website - Signup</title>
    <link rel="icon" href="logo.svg" type="image/x-icon"/>
    <link rel="stylesheet" href="styles.css"> <!-- If you have an external stylesheet -->
</head>


<div class="navbar">
    <ul>
        <li>
            <a href="index.php">
            <img 
            src="logo.svg"
            alt="Logo"
            height=80px
            width=80px />
            </a>
        </li>
        <?php if (!isset($_SESSION["userId"])) { ?>
            <li><a id="navbarButtons" href="login.php">Login</a></li>
            <li><a id="navbarButtons" href="signup.php">Sign up</a></li>
        <?php } else { ?>
            <li><a id="navbarButtons" href="includes/logout.inc.php">Logout</a></li>
        <?php } ?>
    </ul>
</div>

<body>
    <?php 
        showUsername();
    ?>
    <div class="registrationForms" id="signupForm">
        <form action="includes/signup.inc.php" method="post">
            <?php
                signupInputs();
                checkSignupErrors();
            ?>
            <input type="submit" value="Sign up">
          </form> 
    </div>

</body>

</html>