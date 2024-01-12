<?php

function displayEditUser($userID) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/user_controller.inc.php";

    $dbh = new dbh();
    $userController = new UserController($dbh->connect());
    $user = $userController->getUserFromId($userID);

    // Handling if the last page url is not already set
    if (!isset($_SESSION['last_page_url'])) {
        $_SESSION['last_page_url'] = "admin_portal.php";
    }

    if ($user) {
        $output = '
        <div class="container-xxl justify-content-center align-items-center border border-2 border-primary p-3 my-5">
        <div>
        <a href="' . $_SESSION['last_page_url'] . '" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>
        </div>
        <h1 class="text-center">Edit User Details</h1>
        <div class="row gx-5 vw-80">
            <div class="col" id="div1">
                <form action="includes/handlers/edit_details_handler.inc.php" method="post">
                    <div class="form-group">
                        <h4 class="text-center font-weight-bold">User details:</h4>
                        <label for="first-name">First name:</label>
                        <input type="text" class="form-control" name="firstname" aria-describeby="firstName" placeholder="Users firstname" value="' . htmlspecialchars($user["firstname"]) . '">
                    </div>
                    <div class="form-group">
                        <label for="last-name">Surname:</label>
                        <input type="text" class="form-control" name="surname" placeholder="Users surname" value="' . htmlspecialchars($user["surname"]) . '">
                    </div>
                    <div class="form-group">
                        <label for="email-address">Email Address:</label>
                        <input type="text" class="form-control" name="email" placeholder="Users email" value="' . htmlspecialchars($user["email"]) . '">
                    </div>
                    <input type="hidden" name="originalEmail" value="' . htmlspecialchars($user["email"]) . '">
                    <input type="hidden" name="userID" value="' . htmlspecialchars($user["user_id"]) . '">
                    <button type="submit" class="btn btn-primary text-white mt-3">Save changes</button>
                    ' . checkEditUserDetailsErrors() . '
                </form>
            </div>
    
            <div class="col" id="div2">
                <form action="includes/handlers/edit_password_handler.inc.php" method="post">
                    <div class="form-group">
                        <h4 class="text-center font-weight-bold">Change Password:</h4>
                        <label for="new-password">New Password:</label>
                        <input type="password" class="form-control" name="newPwd" placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password:</label>
                        <input type="password" class="form-control" name="confirmPwd" placeholder="Confirm New Password">
                    </div>
                    <input type="hidden" name="userID" value="' . htmlspecialchars($user["user_id"]) . '">
                    <button type="submit" class="btn btn-primary text-white mt-3">Update Password</button>
                    ' . checkEditUserPasswordErrors() . '
                </form>
            </div>
        </div>
        </div>';

        echo $output;
    }

    $user = null;
    $dbh = null;
    $userController = null;
}

function checkEditUserDetailsErrors() {
    $output = "";
    if(isset($_SESSION["editUserDetailsErrors"])) {
        $errors = $_SESSION["editUserDetailsErrors"];

        foreach ($errors as $error) {
            $output .= "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["editUserDetailsErrors"]);
    } else if (isset($_GET["updateDetails"]) && $_GET["updateDetails"] === "success") {
        $output .= "<p class='ml-4 text-success'>Details Updated Successfully!</p>";
    }
    return $output;
}

function checkEditUserPasswordErrors() {
    $output = "";
    if(isset($_SESSION["editUserPasswordErrors"])) {
        $errors = $_SESSION["editUserPasswordErrors"];

        foreach ($errors as $error) {
            $output .= "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["editUserPasswordErrors"]);
    } else if (isset($_GET["updatePassword"]) && $_GET["updatePassword"] === "success") {
        $output .= "<p class='ml-4 text-success'>Password Updated Successfully!</p>";
    }
    return $output;
}