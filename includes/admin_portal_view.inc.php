<?php

declare(strict_types=1);


function createEventInputs() {

    if (isset($_SESSION["eventData"]["name"]) && !isset($_GET["eventCreation"])) {
        echo '
        <div class="form-group">
            <h4 class="text-center font-weight-bold">Signup</h4>
            <label for="eventName">Event Name</label>
            <input type="text" class="form-control mb-2" name="eventName" placeholder="Event Name" value="' . $_SESSION["eventData"]["name"] . '">
        </div>
        ';
    }



}

function checkEventCreationErrors() {
    if(isset($_SESSION["eventCreationErrors"])) {
        $errors = $_SESSION["eventCreationErrors"];
        
        foreach ($errors as $error) {
            echo "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["eventCreationErrors"]);
    } else if (isset($_GET["eventCreation"]) && $_GET["eventCreation"] === "success") {
        echo '<p style="color: green">Event Created Successfully!</p>';

    }
}