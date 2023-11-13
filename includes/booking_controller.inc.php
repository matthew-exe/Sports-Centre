<?php

declare(strict_types=1);


// function isNotLoggedIn() {
//     if (!isset($_SESSION["userID"])) {
//         return true;
//     }
//     else {
//         return false;
//     }
// }

function isAlreadyBooked(object $pdo, string $userID, string $eventID) {
    if (getBooking($pdo, $userID, $eventID)) {
        return true;
    }
    else {
        return false;
    }
}

function isEventFull(object $pdo, string $eventID) {
    if (getEvent($pdo, $eventID)["capacity"] <= sizeof(getBookings($pdo, $eventID))) {
        return true;
    }
    else {
        return false;
    }
}

