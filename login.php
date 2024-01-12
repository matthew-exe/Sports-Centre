<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/configs/session.inc.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/views/login_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Zenith</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.min.css">
</head>

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

<!-- Login form -->
<section class="container-fluid">
    <section class="row justify-content-center align-items-center mt-5">
      <section class="col-12 col-sm-6 col-md-3">
        <form class="form-container bg-white p-5 mb-2 border border-3 border-primary rounded-3" action="includes/handlers/login_handler.inc.php" method="post">
        <div class="form-group">
          <h4 class="text-center font-weight-bold"> Login </h4>
          <label for="email">Email</label>
           <input type="email" class="form-control" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
          <label for="pwd">Password</label>
          <input type="password" class="form-control mb-4" name="pwd" placeholder="Password" required>
        </div>
        <button type="Sign in" class="btn btn-primary text-white">Login</button>
        <div class="form-footer">
          <?php 
            checkLoginErrors();
          ?>
          <p> Don't have an account? <a class="link-primary" href="signup.php">Sign Up</a></p>
        </div>
        </form>
      </section>
    </section>
  </section>

<body>

<script src="node_modules//bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>