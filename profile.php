<?php
require_once "includes/config_session.inc.php";
if (!isset($_SESSION["userID"])) {
    header("Location: index.php");
    die();
}
require_once "includes/profile_view.inc.php";
require_once "includes/booking_view.inc.php";
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
    <link rel="stylesheet" href="css/styles.min.css"> <!-- If you have an external stylesheet -->
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
  <!-- Login form -->
  <div class="container-xxl justify-content-center align-items-center border border-2 border-primary p-3 my-5">
    <div class="row gx-5 vw-80">
      <div class="col" id="div1">
        <form action="includes/update_details.inc.php" method="post">
          <?php 
          profileData();
          checkUpdateDetailsErrors()
          ?>
          <button type="submit" class="btn btn-primary text-white mt-3">Save changes</button>
        </form>
      </div>

      <div class="col" id="div2">
        <form action="includes/update_password.inc.php" method="post">
          <div class="form-group">
            <h4 class="text-center font-weight-bold">Change Password</h4>
            <label for="current-password">Current Password:</label>
            <input type="password" class="form-control" name="currentPassword" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="new-password">New Password:</label>
            <input type="password" class="form-control" name="newPassword" placeholder="Enter New Password">
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm New Password:</label>
            <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm New Password">
          </div>
          <?php
          checkUpdatePasswordErrors();
          ?>
          <button type="submit" class="btn btn-primary text-white mt-3">Update Password</button>
        </form>
      </div>
    </div>
  </div>

  <!-- bookings cards -->
  <div class="container-xxl">
      <section class="mt--3 mb-3 border border-2 border-primary vw-80">
        <?php 
        displayBookings();
        ?>
      </section>
  </section>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
</body>

</html>