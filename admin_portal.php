<?php
require_once "includes/config_session.inc.php";
require_once "includes/admin_portal_view.inc.php";
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
                        <li><label for="eventDescription">Event Description</label></li>
                        <li class="mb-2"><input type="textarea" name="eventDescription" placeholder="Event Decription..."></li>
                </div>
                <div class="col">
                <label for="eventImage">Event Image</label>
                    <select name="eventImage">
                        <option value="images/bighenchman.jpg">Big Hench Man</option>
                        <option value="images/hellokitty.jpg">Hello Kitty</option>
                        <option value="images/wegogym.jpg">We Go Gym</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php 
                    checkEventCreationErrors();
                    ?>
                </div>
            </div>
        </div>
    </form>

    <!-- <div class="container">
        <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
            <form>
                <div class="col">balls
                    <h1>Create Event:</h1>
                    <label for="eventName">Event Name</label>
                    <input type="text" name="eventName" placeholder="Event Name...">
                    <label for="eventDate">Event Date</label>
                    <input type="date" name="evenDate">
                    <label for="eventTime">Event Time</label>
                    <input type="time" name="eventTime">
                    <label for="eventHost">Event Host</label>
                    <select name="eventHost">
                        <option value="Jamie">Jamie</option>
                        <option value="Russell">Russell</option>
                        <option value="Matt">Matt</option>
                        <option value="Felix">Felix</option>
                        <option value="Gab">Gab</option>
                    </select>
                    <label for="eventCapacity">Event Capacity</label>
                    <input type="text" name="eventCapacity" placeholder="Event Capacity">
                    <label for="eventDescription">Event Name</label>
                    <input type="textarea" name="eventDescription" placeholder="Event Decription..."> 
                </div>
                <div class="col">dick</div>
            </form>
        </div> -->

</body>