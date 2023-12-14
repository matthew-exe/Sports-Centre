<?php
require_once "includes/configs/session.inc.php";
if (!isset($_SESSION["userID"])) {
    header("Location: error.php");
    die();
}
require_once "includes/views/profile_view.inc.php";

$_SESSION['last_page_url'] = $_SERVER['REQUEST_URI'];
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
  <!-- Login form -->
  <div class="container-xxl align-items-center justify-content-center border border-2 border-primary p-3 my-5">
    <div class="row gx-5 vw-80">
      <div class="col" id="div1">
        <form action="includes/handlers/update_details_handler.inc.php" method="post">
          <?php 
          displayProfileData();
          checkUpdateDetailsErrors()
          ?>
          <button type="submit" class="btn btn-primary text-white mt-3">Save changes</button>
        </form>
      </div>

      <div class="col" id="div2">
        <form action="includes/handlers/update_password_handler.inc.php" method="post">
          <div class="form-group">
            <h4 class="text-center font-weight-bold">Change Password</h4>
            <label for="current-password">Current Password:</label>
            <input type="password" class="form-control" name="pwd" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="new-password">New Password:</label>
            <input type="password" class="form-control" name="newPwd" placeholder="Enter New Password">
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm New Password:</label>
            <input type="password" class="form-control" name="confirmPwd" placeholder="Confirm New Password">
          </div>
          <?php
          checkUpdatePasswordErrors();
          ?>
          <button type="submit" class="btn btn-primary text-white mt-3">Update Password</button>
        </form>
        
        <div class="d-flex justify-content-end mt-3">
          <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete account</button>
        </div>

        <!-- Delete modal -->
        <div class="modal" id="deleteModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Delete account?</h4>
              </div>

              <div class="modal-body">
                Are you sure you want to delete your account? This cannot be undone.
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="container-xxl justify-content-center align-items-center border border-2 border-primary pt-4">
    <h1 class="h1 justify-content-start">Your bookings:</h1>
    <section class="row vw-80">
      <section class="col-12 col-sm-12 col-md-12">
        <form action="profile.php" method="get" id="searchForm">
          <div class="input-group mb-3 mt-3">
            <input type="text" name="searchInput" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon2">
            <input type="date" class="form-control" id="dateFilter" name="dateFilter">
            <div class="input-group-append">
              <button class="btn btn-primary ms-2" type="submit">Submit</button>
              </div>
          </div>
        </form>


                <?php
                    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $dateFilter = isset($_GET["dateFilter"]) ? $_GET["dateFilter"] : '';
                    $search = isset($_GET["searchInput"]) ? $_GET["searchInput"] : '';
                
                    displayUsersBookedActivities($page, $dateFilter, $search);
                ?>
            </section>
        </section>
    </section>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
</body>



</html>