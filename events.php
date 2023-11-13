<?php
require_once "includes/config_session.inc.php";
require_once "includes/search_view.inc.php";
require_once "includes/events_view.inc.php";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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
            <?php if (!isset($_SESSION["userID"])) { ?>
              <div class="navbar-nav mb-0 ms-auto">
                <a class="btn btn-light text-dark ms-3" href="events.php">Events</a>
                <a class="btn btn-light text-dark ms-3" href="login.php">Login</a>
                <a class="btn btn-light text-dark ms-3" href="signup.php">Signup</a>
              </div>
            <?php } else { ?>
                <div class="navbar-nav mb-0 ms-auto">
                <a class="btn btn-light text-dark ms-3" href="events.php">Events</a>
                <a class="btn btn-light text-dark ms-3" href="profile.php">Profile</a>  
                <a class="btn btn-light text-dark ms-3" href="includes/logout.inc.php">Logout</a>
              </div>
            <?php } ?>
        </div>
    </div>
</nav>


<body>
    <!-- Start of container including search bar -->
    <section class="container-fluid">
        <section class="row justify-content-center align-items-center vw-90 pt-5">
            <section class="col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
            <form action="events.php" method="get">
                <div class="input-group mb-3 mt-3">
                    <input type="text" name="searchInput" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
    
                <?php
                    if (isset($_GET["searchInput"])) {
                        displaySearchedEvents($_GET["searchInput"]);
                    }
                    else {
                        displayEvents();
                    }
                ?>
            </section>
        </section>
    </section>






</body>

</html>