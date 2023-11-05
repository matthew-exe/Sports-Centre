<?php
    require_once "includes/config_session.inc.php";
    require_once "includes/profile_view.inc.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website - Homepage</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon"/>
    <link rel="stylesheet" href="styles.css"> <!-- If you have an external stylesheet -->
</head>


<div class="navbar">
    <ul>
        <li>
            <a href="index.php">
            <img
            src="images/logo.svg"
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
    <div class="registrationForms" id="signupForm">
        <form action="includes/profile.inc.php" method="post">
            <?php
                profileData();
                checkProfileEditErrors();
            ?>
            <input type="submit" value="Edit Profile">
          </form> 
    </div>
</body>

</html>
