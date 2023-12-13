<?php
require_once "includes/configs/session.inc.php";
require_once "includes/views/activities_view.inc.php";

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


<body>
    <!-- Start of container including search bar -->
    <section class="container-fluid">
        <section class="row justify-content-center align-items-center vw-90 pt-5">
            <section class="col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
            <form action="activities.php" method="get" id="searchForm">
            <div class="input-group mb-3 mt-3">
                <input type="text" name="searchInput" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon2">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Toggle Options
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filters">
                        <li><a class="dropdown-item" href="#" data-filter="closestdate">Sort by closest date</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="notfullybooked">Exclude Fully Booked Events</a></li>
                    </ul>
                </div>
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
                    $filters = isset($_GET["filters"]) ? $_GET["filters"] : [];
                
                    displayActivities($page, $dateFilter, $search, $filters);
                ?>
            </section>
        </section>
    </section>


<footer class="footer container-fluid d-flex footer-expand-large justify-content-between align-items-center py-3 mt-4 border-top bg-primary footer-fixed-bottom">
    <p class="col-md-4 mb-0 text-white">© 2023 WPT1 </p>
  
    <a class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none" href="index.php">
      <img src="images/logo.svg" width="40" height="32">
    </a>
  
    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Events</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Sessions</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-white">About</a></li>
    </ul>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let filters = [];
        document.querySelectorAll('#filters .dropdown-item.active').forEach(filter => {
            filters.push(filter.dataset.filter);
        });

        const searchInput = document.querySelector('input[name="searchInput"]').value;
        const dateFilter = document.getElementById('dateFilter').value;

        const queryParams = new URLSearchParams();
        queryParams.append('searchInput', searchInput);
        queryParams.append('dateFilter', dateFilter);
        filters.forEach(filter => {
            queryParams.append('filters[]', filter);
        });

        const queryString = queryParams.toString();
        const actionUrl = this.getAttribute('action') + '?' + queryString;

        window.location.href = actionUrl;
    });

    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            item.classList.toggle('active');
        });
    });
</script>

</body>


</html>

