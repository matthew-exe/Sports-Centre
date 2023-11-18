<?php

declare(strict_types=1);


// function createEventInputs() {

//     if (isset($_SESSION["eventData"]["name"]) && !isset($_GET["eventCreation"])) {
//         echo '
//         <div class="form-group">
//             <h4 class="text-center font-weight-bold">Signup</h4>
//             <label for="eventName">Event Name</label>
//             <input type="text" class="form-control mb-2" name="eventName" placeholder="Event Name" value="' . $_SESSION["eventData"]["name"] . '">
//         </div>
//         ';
//     }



// }

function checkEventCreationErrors() {
    if(isset($_SESSION["eventCreationErrors"])) {
        $errors = $_SESSION["eventCreationErrors"];
        
        foreach ($errors as $error) {
            echo "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["eventCreationErrors"]);
    } else if (isset($_GET["eventCreation"]) && $_GET["eventCreation"] === "success") {
        echo '<p class="ml-4" style="color: green">Event Created Successfully!</p>';

    }
}


function displayUsers() {
    require_once "dbh.inc.php";
    require_once "admin_portal_model.inc.php";

    $dbh = new dbh();
    $users = getUsers($dbh->connect());
    $dbh = null;

    if ($users > 0) {
        $counter = 1;
        $output = 'There are no users currently signed up!';
        foreach($users as $user) {
            if ($counter == 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $user["firstname"] . " " . $user["surname"] . '</h5>
                <p class="card-text">' . $user["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreUserInfo" value="' . $user["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else if ($counter != 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $user["firstname"] . " " . $user["surname"] . '</h5>
                <p class="card-text">' . $user["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreUserInfo" value="' . $user["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $user["firstname"] . " " . $user["surname"] . '</h5>
                <p class="card-text">' . $user["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreUserInfo" value="' . $user["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                </div>
                </div> 
                ';
                $counter = 1;
                echo $output;
                $output = '';
            }
        }
        if ($output != '') { 
            echo $output;
        }
    }
}

function displaySearchedUsers(string $searchInput) {

    require_once "dbh.inc.php";
    require_once "admin_portal_model.inc.php";

    $dbh = new dbh();
    $searchResult = searchUsers($dbh->connect(), $searchInput);
    $dbh = null;
    

    if ($searchResult > 0) { 
        $counter = 1;
        $output = 'There was no search results!'; 
        foreach ($searchResult as $result) {
            if ($counter == 1) {
                $output = '
                <div class="row my-5">
                <div class="card-group">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["firstname"] . " " . $result["surname"] . '</h5>
                <p class="card-text">' . $result["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreInfo" value="' . $result["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else if ($counter != 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["firstname"] . " " . $result["surname"] . '</h5>
                <p class="card-text">' . $result["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreInfo" value="' . $result["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                ';
                $counter++;
            }
            else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" style="max-width: 18rem;">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . $result["firstname"] . " " . $result["surname"] . '</h5>
                <p class="card-text">' . $result["email"] . '</p>
                <form action="userinfo.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="moreInfo" value="' . $result["userID"] . '">More info</button>
                </form>
                </div>
                </div>
                </div>
                </div> 
                ';
                $counter = 1;
                echo $output;
                $output = '';
            }
        }
        if ($output != '') {
            echo $output;
        }
    }
    unset($_SESSION["searchInput"]);
}