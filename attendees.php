<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";
if (!isset($_SESSION["userID"]) || $_SESSION["userGroup"] != "Admin") {
    header("Location: index.php");
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/views/attendees_view.inc.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendees - Zenith - Homepage</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon"/>
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

<section class="container-fluid">
    <section class="row justify-content-center align-items-center vw-90 pt-5">
        <section class="col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
            <div>
                <?php
                echo '<a href="'.$_SESSION['last_activity_page_url'].'" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>'
                ?>
            </div>
            <h1 class="mt-2" >Search Attending Users:</h1>
            <form action="attendees.php" method="get">
                <div class="input-group mb-3 mt-3">
                    <input type="text" name="searchInput" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon2">
                    <input type="hidden" name="activityID" value="<?php echo $_GET['activityID']; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>

            <?php

            $page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $search = isset($_GET["searchInput"]) ? $_GET["searchInput"] : '';

            if (isset($_GET["activityID"])) {
                displayAttendingUsers($_GET["activityID"], $page, $search);
            }
            ?>
        </section>
    </section>
</section>


<script src="node_modules//bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>