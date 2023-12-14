<?php

function checkActivityCreationErrors() {
    if(isset($_SESSION["activityCreationErrors"])) {
        $errors = $_SESSION["activityCreationErrors"];
        
        foreach ($errors as $error) {
            echo "<p style='color: red'>$error</p>";
        }

        unset($_SESSION["activityCreationErrors"]);
    } else if (isset($_GET["creation"]) && $_GET["creation"] === "success") {
        echo '<p class="ml-4" style="color: green">Event Created Successfully!</p>';
    }
}