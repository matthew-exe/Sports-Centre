<?php
// require_once "includes/login_view.inc.php";
// require_once "includes/config_session.inc.php";
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
    <link rel="stylesheet" href="css/styles.min.css"></head>

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
            <?php if (isset($_SESSION["userID"]) && $_SESSION["userGroup"] == "admin") { ?>
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


<div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/slide1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/slide2.png" class="d-block w-100" alt="...">
    </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="container">
  <div class="row mt-5">
      <div class="col pb-5">
          <img class="mt-5"src="images/sportscentre.jpg" alt="" height="400" width="550">
          <br>
      </div>
      <div class="col mb-5 fs-4 mr-3">
        <h2 class="mt-5 mb-5"><strong>About Us</strong></h2>
          <p class="mt-5"><strong>Zenith Sports Hub</strong> is more than a sports center; 
            it's a community-driven space dedicated to excellence in fitness 
            and athletic achievement. Our state-of-the-art facilities and 
            expert trainers cater to individuals of all levels and ages. 
            We believe in the transformative power of sports and aim to 
            create an environment where you can push your limits, achieve 
            your fitness goals, and be a part of a vibrant community. 
            Join us at Zenith Sports Hub, where passion meets performance!</p>
      </div>
  </div>

  <hr style="border-width: 2px;">

  <div class="row">
      <div class="col mb-5 fs-4 mr-3">
      <h2 class="mt-5 mb-5"><strong>Contact us</strong></h2>
          <p class="mt-5">Come find us at <strong>Zenith Sports Hub</strong>, Unit E4, Arena Business Centre, Holyrood CL, Poole BH17 7FJ<br>
          <br>
            <strong>Email:</strong> info@ZenithSports.com<br>
            <strong>Phone Number:</strong> 07904111242<br>
            <strong>Instagram:</strong> @ZenithSports<br>
            <strong>X:</strong> @ZenithSportsHub<br>
            <strong>Facebook:</strong> @ZenithSports
          </p>
      </div>
      <div class="col">
      <iframe class="mt-3"src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d315.5945681257861!2d-1.9939281199011423!3d50.74300415024202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4873a716f2ae0daf%3A0x7b4553d762ce0bd1!2sUnit%20E4!5e0!3m2!1sen!2suk!4v1702326231677!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>  </div>

  <hr style="border-width: 2px;">

  <div class="row text-center">
    <div class="col mb-5 fs-4">
        <h2 class="mt-5 mb-5">Get in touch!</h2>
        <p>Got a question or request? Let us know, and we will reply as soon as possible!</p>
        <form>
            <div class="row justify-content-center mb-3">
                <div class="col-md-5 mb-3">
                    <input type="text" class="form-control" placeholder="Your Name">
                </div>
                <div class="col-md-5 mb-3">
                    <input type="text" class="form-control" placeholder="Your Email">
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    <input type="textarea" class="form-control" style="height: 150px;" placeholder="Your Message">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <button class="btn btn-primary text-white" style="width: 100%;">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>



</html>