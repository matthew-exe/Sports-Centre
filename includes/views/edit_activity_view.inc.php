<?php

function displayEditActivity($activityID) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/configs/dbh.inc.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/wpassignment/includes/controllers/activity_controller.inc.php";

    $dbh = new dbh();
    $activityController = new ActivityController($dbh->connect());
    $activity = $activityController->getActivityById($activityID);



    // Handling if the last page url is not already set
    if (!isset($_SESSION['last_activity_page_url'])) {
        $_SESSION['last_activity_page_url'] = "activities.php";
    }
    if ($activity) {
        $output = '
        <form action="includes/handlers/edit_activity_handler.inc.php" method="POST">
            <div class="container col-12 col-sm-6 col-md-8 border border-3 border-primary rounded-3">
                <div>
                    <a href="' . $_SESSION['last_activity_page_url'] . '" class="close-button top-0 end-0 m-1 float-end text-decoration-none text-dark"><strong>X</strong></a>
                </div>
                <div class="row">
                    <div class="col">
                        <ol class="mt-5 list-unstyled">
                            <h1 class="ml-4"><strong>Edit Activity:</strong></h1>
                            <li><label for="activityName">Activity Name</label></li>
                            <li class="mb-2"><input type="text" name="activityName" placeholder="Activity Name..." required value="' . htmlspecialchars($activity["name"]) . '"></li>
                            <li><label for="activityDate">Activity Date</label></li>
                            <li class="mb-2"><input type="date" name="activityDate" required value="' . htmlspecialchars($activity["activity_date"]) . '"></li>
                            <li><label for="activityTime">Activity Time</label></li>
                            <li class="mb-2"><input type="time" name="activityTime" required value="' . htmlspecialchars($activity["activity_time"]) . '"></li>
                            <li><label for="activityHost">Activity Host</label></li>
                            <li class="mb-2">
                                <select name="activityHost">
                                    <option value="Jamie" ' . (htmlspecialchars($activity["host"]) == "Jamie" ? "selected" : "") . '>Jamie</option>
                                    <option value="Russell" ' . (htmlspecialchars($activity["host"]) == "Russell" ? "selected" : "") . '>Russell</option>
                                    <option value="Matt" ' . (htmlspecialchars($activity["host"]) == "Matt" ? "selected" : "") . '>Matt</option>
                                    <option value="Felix" ' . (htmlspecialchars($activity["host"]) == "Felix" ? "selected" : "") . '>Felix</option>
                                    <option value="Gab" ' . (htmlspecialchars($activity["host"]) == "Gab" ? "selected" : "") . '>Gab</option>
                                </select>
                            </li>
                            <li><label for="activityCapacity">Activity Capacity</label></li>
                            <li class="mb-2"><input type="text" name="activityCapacity" placeholder="Activity Capacity" required value="' . htmlspecialchars($activity["capacity"]) . '"></li>
                             <li class="mb-2"><label for="activityImage">Activity Image</label></li>
                                    <li class="mb-2"><select name="activityImage">
                                        <option value="badminton.png" '.(htmlspecialchars($activity["image"]) == "badminton.png" ? "selected" : "").'>Badminton</option>
                                        <option value="basketball.png" '.(htmlspecialchars($activity["image"]) == "basketball.png" ? "selected" : "").'>Basketball</option>
                                        <option value="dodgeball.png" '.(htmlspecialchars($activity["image"]) == "dodgeball.png" ? "selected" : "").'>Dodgeball</option>
                                        <option value="kick_boxing.png" '.(htmlspecialchars($activity["image"]) == "kick_boxing.png" ? "selected" : "").'>Kick Boxing</option>
                                        <option value="krav_maga.png" '.(htmlspecialchars($activity["image"]) == "krav_maga.png" ? "selected" : "").'>Krav Maga</option>
                                        <option value="swimming.png" '.(htmlspecialchars($activity["image"]) == "swimming.png" ? "selected" : "").'>Swimming</option>
                                        <option value="table_tennis.png" '.(htmlspecialchars($activity["image"]) == "table_tennis.png" ? "selected" : "").'>Table Tennis</option>
                                        <option value="volleyball.png" '.(htmlspecialchars($activity["image"]) == "volleyball.png" ? "selected" : "").'>Volleyball</option>
                                    </select></li>
                            <li class="mb-2"><input type="hidden" name="activityID" value="' . htmlspecialchars($activity["activity_id"]) . '"></li>
                        </ol>
                        </ol>
                    </div>
                    <div class="col mt-2">
                        <ol class="mt-5 list-unstyled">
                            <li><label for="shortDescription">Short Description For This Activity</label></li>
                            <li class="mb-2"><input type="text" name="shortDescription" placeholder="Enter short Decription" required class="form-control w-75" value="'.htmlspecialchars($activity["short_description"]).'"></li>
                            <li class="mb-2"><label for="longDescription">Long Description For This Activity</label></li>
                            <li class="mb-2"><textarea name="longDescription" placeholder="Enter Long Description" class="form-control w-75" required>'. htmlspecialchars($activity["long_description"]).'</textarea>
                            </li>
                            <li class="mb-2"><button type="submit" class="ml-1 mt-3 btn btn-primary">Submit</button></li>
                        </ol>
                        ' . checkActivityUpdateErrors() . '
                    </div>
                </div>
            </div>
        </form>';

        echo $output;
    }

    $dbh = null;
    $activityController = null;
}

function checkActivityUpdateErrors() {
    $output = "";
    if(isset($_SESSION["activityUpdateErrors"])) {
        $errors = $_SESSION["activityUpdateErrors"];
        
        foreach ($errors as $error) {
            $output .= "<p class='text-danger'>$error</p>";
        }

        unset($_SESSION["activityUpdateErrors"]);
    } else if (isset($_GET["update"]) && $_GET["update"] === "success") {
        $output .= "<p class='ml-4 text-success'>Activity Updated Successfully!</p>";
    }
    return $output;
}