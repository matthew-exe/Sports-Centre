<?php

function displayEditActivity($activityID) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/Web-Programming/includes/controllers/activity_controller.inc.php";

    $dbh = new dbh();
    $activityController = new ActivityController($dbh->connect());
    $activity = $activityController->getActivityById($activityID);



    // Handling if the last page url is not already set
    if (!isset($_SESSION['last_page_url'])) {
        $_SESSION['last_page_url'] = "activities.php";
    }

    $output = '
    <form action="includes/admin_portal.inc.php" method="POST">
    <div class="container col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
            <div>
            <a href="'. $_SESSION['last_page_url'] .'" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>
            </div>
        <div class="row">
            <div class="col">
                <ol style="list-style-type: none">
                    <h1 class="ml-4"><strong>Edit Activity:</strong></h1>
                    <li><label for="activityName">Activity Name</label></li>
                    <li class="mb-2"><input type="text" name="activityName" placeholder="Activity Name..." value='.$activity["name"].'></li>
                    <li><label for="activityDate">Activity Date</label></li>
                    <li class="mb-2"><input type="date" name="activityDate"></li>
                    <li><label for="activityTime">Activity Time</label></li>
                    <li class="mb-2"><input type="time" name="activityTime"></li>
                    <li><label for="activityHost">Activity Host</label></li>
                    <li class="mb-2"><select name="activityHost"></li>
                        <option value="Jamie">Jamie</option>
                        <option value="Russell">Russell</option>
                        <option value="Matt">Matt</option>
                        <option value="Felix">Felix</option>
                        <option value="Gab">Gab</option>
                    <li class="mb-2"></select></li>
                    <li><label for="activityCapacity">Activity Capacity</label></li>
                    <li class="mb-2"><input type="text" name="activityCapacity" placeholder="Activity Capacity"></li>
                    <li class="mb-2"><label for="activityImage">Activity Image</label></li>
                    <li class="mb-2"><select name="activityImage">
                        <option value="images/bighenchman.jpg">Big Hench Man</option>
                        <option value="images/hellokitty.jpg">Hello Kitty</option>
                        <option value="images/wegogym.jpg">We Go Gym</option>
                        </select></li>
                </ol>
            </div>
            <div class="col mt-2">
                <ol class="mt-5" style="list-style-type: none">
                    <li><label for="shortDescription">Short Description For This Activity</label></li>
                    <li class="mb-2"><input style="height: 75px; width: 300px" type="text" name="shortDescription" placeholder="Enter short Decription"></li>
                    <li class="mb-2"><label for="longDescription">Long Description For This Activity</label></li>
                    <li class="mb-2"><textarea style="height: 150px; width: 300px" name="longDescription" placeholder="Enter Long Decription"></textarea></li>
                    <li class="mb-2"><button type="submit" class="ml-1 mt-3 btn btn-primary">Submit</button></li>
                </ol>
                '.checkActivityUpdateErrors().'
            </div>
        </div>
        </div>
    </form>;';

    echo $output;

    $dbh = null;
    $activityController = null;
}

function checkActivityUpdateErrors() {
    $output = "";
    if(isset($_SESSION["activityUpdateErrors"])) {
        $errors = $_SESSION["activityUpdateErrors"];
        
        foreach ($errors as $error) {
            $output .= "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["activityUpdateErrors"]);
    } else if (isset($_GET["update"]) && $_GET["update"] === "success") {
        $output .= '<p class="ml-4" style="color: green">Activity Updated Successfully!</p>';
    }
    return $output;
}