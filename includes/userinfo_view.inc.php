<?php

declare(strict_types=1);

function displayExpandedUser(int $userID) {

    require_once "dbh.inc.php";
    require_once "admin_portal_model.inc.php";
    require_once "admin_portal_view.inc.php";

    $dbh = new dbh();
    $user = getSpecificUser($dbh->connect(), $userID);
    $dbh = null;

    $output = '
    <div class="container">
        <div class="row bg-light text-dark3 border border-2 border-primary rounded-3">
            <div class="col-sm-7">
                <div>
                    <h1 class="mt-3 mb-1">' . $user["firstname"] . " " . $user["surname"] . '</h1>
                    <p class="mb-3">Account Created: ' . date("d/m/Y H:i", strtotime($user["created_at"])) . '</p>
                    <p class="mb-4">' . $user["email"] . '</p>
                    <form class="ml-5 mt-3" action="includes/delete_user.inc.php" method="post">
                        <button type="submit" class="btn btn-primary" name="userID" id="deleteUser" value="' . $user["userID"] . '">Delete User</button>
                    </form>
                    ';

    $output .= '
                </div>
            </div>
            <div class="col-sm-5">
            <img src="images/user_icon.png" class="img-fluid">
            </div>
        </div>
    </div>
    ';

    echo $output;
}