<?php
// require_once "includes/config_session.inc.php";
// require_once "includes/userinfo_view.inc.php";
// require_once "includes/booking_view.inc.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website - Homepage</title>
    <link rel="icon" href="logo.svg" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.min.css">
</head>

<!-- Navbar -->
<nav class="navbar navbar-fixed-top navbar-expand-lg p-3 mb-3 bg-primary">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="index.php" id="logo">
            <img src="images/logo.svg" alt="logo" height="54px" d-inline-block align-text-top>
        </a>

        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-black pt-1">=</span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <?php if (isset($_SESSION["userID"]) && $_SESSION["userGroup"] == "Admin") { ?>
                <div class="navbar-nav mb-0 ms-auto">
                <a class="btn btn-light text-dark ms-3" href="activities.php">Activities</a>
                <a class="btn btn-light text-dark ms-3" href="admin_portal.php">Admin Portal</a>                
                <a class="btn btn-light text-dark ms-3" href="profile.php">Profile</a>  
                <a class="btn btn-light text-dark ms-3" href="includes/handlers/logout_handler.inc.php">Logout</a>
              </div>
            <?php } elseif (isset($_SESSION["userID"])) {?>
                <div class="navbar-nav mb-0 ms-auto">
                <a class="btn btn-light text-dark ms-3" href="activities.php">Activities</a>
                <a class="btn btn-light text-dark ms-3" href="profile.php">Profile</a>  
                <a class="btn btn-light text-dark ms-3" href="includes/handlers/logout_handler.inc.php">Logout</a>
              </div>               
            <?php } else { ?>
                <div class="navbar-nav mb-0 ms-auto">
                <a class="btn btn-light text-dark ms-3" href="activities.php">Activities</a>
                <a class="btn btn-light text-dark ms-3" href="login.php">Login</a>
                <a class="btn btn-light text-dark ms-3" href="signup.php">Signup</a>
              </div>
            <?php } ?>
        </div>
    </div>
</nav>


<body>
    <?php
        if (isset($_GET["userID"])) {
            displayExpandedUser($_GET["userID"]);
        }
    ?>


    <footer class="footer container-fluid d-flex justify-content-between align-items-center py-3 mt-4 border-top bg-primary position-absolute start-50 top-100 translate-middle">
        <p class="col-md-4 mb-0 text-white">© 2023 Zenith Sports Hub </p>

        <a class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none" href="index.php">
            <img src="images/logo.svg" width="40" height="32">
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
            <li class="nav-item"><a href="activities.php" class="nav-link px-2 text-white">Activities</a></li>
        </ul>
    </footer>
<script src="node_modules//bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

