<?php

function checkActivityCreationErrors() {
    if(isset($_SESSION["activityCreationErrors"])) {
        $errors = $_SESSION["activityCreationErrors"];
        
        foreach ($errors as $error) {
            echo "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["activityCreationErrors"]);
    } else if (isset($_GET["creation"]) && $_GET["creation"] === "success") {
        echo '<p class="ml-4 text-success">Event Created Successfully!</p>';
    }
}


function displayUsers($page = 1, $search = '') {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/user_controller.inc.php";

    $dbh = new dbh();
    $userController = new UserController($dbh->connect());

    // Get total count of users based on search
    $totalUsers = $userController->getTotalUsersCount($search);

    if (isset($totalUsers)) {
        $perPage = 4;
        $totalPages = ceil($totalUsers / $perPage);
    } else {
        $totalPages = 0;
    }

    // Calculate the offset for the SQL query based on current page
    $offset = (intval($page) - 1) * $perPage;

    // Get job listings for the current page based on search and filter
    $users = $userController->getUsersPaginated($perPage, $offset, $search);

    $output = "";
    if ($users) {
        $counter = 1;
        foreach ($users as $user) {
            if ($counter === 1) {
                $output = '
                 <div class="row my-5">
                <div class="card-group justify-content-start">
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($user["firstname"]) . " " . htmlspecialchars($user["surname"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($user["email"]) . '</p>
                <p class="card-text">Group: ' . htmlspecialchars($user["group_name"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="edit_user.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="editUser" value="' . htmlspecialchars($user["user_id"]) . '">Edit User</button>
                </form>
                <form action="includes/handlers/delete_user_handler.inc.php" method="post" class="mx-3">
                <button type="submit" class="btn btn-danger" name="userID" id="deleteUser" value="' . htmlspecialchars($user["user_id"]) . '">Delete User</button>
                </form>
                </div>
                </div>
                </div>
                ';
                $counter++;
            } else if ($counter !== 1 && $counter < 4) {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($user["firstname"]) . " " . htmlspecialchars($user["surname"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($user["email"]) . '</p>
                <p class="card-text">Group: ' . htmlspecialchars($user["group_name"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="edit_user.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="editUser" value="' . htmlspecialchars($user["user_id"]) . '">Edit User</button>
                </form>
                <form action="includes/handlers/delete_user_handler.inc.php" method="post" class="mx-3">
                <button type="submit" class="btn btn-danger" name="userID" id="deleteUser" value="' . htmlspecialchars($user["user_id"]) . '">Delete User</button>
                </form>
                </div>
                </div>
                </div>
                ';
                $counter++;
            } else {
                $output .= '
                <div class="card mx-2 bg-light text-dark border border-2 border-primary rounded-3" id="outputCard">
                <img src="images/user_icon.png" class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">' . htmlspecialchars($user["firstname"]) . " " . htmlspecialchars($user["surname"]) . '</h5>
                <p class="card-text">' . htmlspecialchars($user["email"]) . '</p>
                <p class="card-text">Group: ' . htmlspecialchars($user["group_name"]) . '</p>
                <div class="d-flex justify-content-start">
                <form action="edit_user.php" method="get">
                <button type="submit" class="btn btn-primary" name="userID" id="editUser" value="' . htmlspecialchars($user["user_id"]) . '">Edit User</button>
                </form>
                <form action="includes/handlers/delete_user_handler.inc.php" method="post" class="mx-3">
                <button type="submit" class="btn btn-danger" name="userID" id="deleteUser" value="' . htmlspecialchars($user["user_id"]) . '">Delete User</button>
                </form>
                </div>
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
        if (!empty($output)) {
            $output .= '
            </div>
            </div> ';
            echo $output;
        }


        echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $params = http_build_query(array_merge($_GET, ['page' => $i]));
            if ($i == $page) {
                echo '<li class="page-item active"><a class="page-link" href="?' . $params . '">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?' . $params . '">' . $i . '</a></li>';
            }
        }
        echo '</ul></nav>';
    } else {
        echo '<p>Sorry, there are currently no users that match your search.</p>';
    }

    $dbh = null;
    $userController = null;
}