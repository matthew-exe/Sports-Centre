<?php
// require_once "includes/config_session.inc.php";
// if (!isset($_SESSION["userID"]) || $_SESSION["userGroup"] != "admin") {
//     header("Location: index.php");
//     die();
// }
// require_once "includes/admin_portal_view.inc.php";
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
    
    <form action="includes/admin_portal.inc.php" method="POST">
        <div class="container">
            <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
                <div class="col">
                <h1 class="ml-4">Create Event:</h1>
                    <ol style="list-style-type: none">
                        <li><label for="eventName">Event Name</label></li>
                        <li class="mb-2"><input type="text" name="eventName" placeholder="Event Name..."></li>
                        <li><label for="eventDate">Event Date</label></li>
                        <li class="mb-2"><input type="date" name="eventDate"></li>
                        <li><label for="eventTime">Event Time</label></li>
                        <li class="mb-2"><input type="time" name="eventTime"></li>
                        <li><label for="eventHost">Event Host</label></li>
                        <li class="mb-2"><select name="eventHost"></li>
                            <option value="Jamie">Jamie</option>
                            <option value="Russell">Russell</option>
                            <option value="Matt">Matt</option>
                            <option value="Felix">Felix</option>
                            <option value="Gab">Gab</option>
                        <li class="mb-2"></select></li>
                        <li><label for="eventCapacity">Event Capacity</label></li>
                        <li class="mb-2"><input type="text" name="eventCapacity" placeholder="Event Capacity"></li>
                        <li class="mb-2"><label for="eventImage">Event Image</label></li>
                        <li class="mb-2"><select name="eventImage">
                            <option value="images/bighenchman.jpg">Big Hench Man</option>
                            <option value="images/hellokitty.jpg">Hello Kitty</option>
                            <option value="images/wegogym.jpg">We Go Gym</option>
                            </select></li>
                    </ol>
                </div>
                <div class="col mt-2">
                    <ol class="mt-1" style="list-style-type: none">
                        <li><label for="shortDescription">Short Description For This Event</label></li>
                        <li class="mb-2"><input style="height: 75px; width: 300px" type="text" name="shortDescription" placeholder="Enter short Decription"></li>
                        <li class="mb-2"><label for="longDescription">Long Description For This Event</label></li>
                        <li class="mb-2"><textarea style="height: 150px; width: 300px" name="longDescription" placeholder="Enter Long Decription"></textarea></li>
                        <li class="mb-2"><button type="submit" class="ml-1 mt-3 btn btn-primary">Submit</button></li>
                    </ol>
                    <?php 
                    checkEventCreationErrors();
                    ?>
                </div>
            </div>
        </div>
    </form>

    <section class="container-fluid">
        <section class="row justify-content-center align-items-center vw-90 pt-5">
            <section class="col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
            <h1 class="mt-2" >Search Users:</h1>
            <form action="admin_portal.php" method="get">
                <div class="input-group mb-3 mt-3">
                    <input type="text" name="searchInput" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
    
                <?php
                    if (isset($_GET["searchInput"])) {
                        displaySearchedUsers($_GET["searchInput"]);
                    }
                    else {
                        displayUsers();
                    }
                ?>
            </section>
        </section>
    </section>

</body>

