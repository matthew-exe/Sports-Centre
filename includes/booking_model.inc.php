<?php

declare (strict_types= 1);

function getEvent(object $pdo, string $eventID) {
    $query = "SELECT * FROM events WHERE eventID = :eventID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getBookings(object $pdo, string $eventID) {
    $query = "SELECT * FROM bookings WHERE eventID = :eventID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getBooking(object $pdo, string $userID, string $eventID) {
    $query = "SELECT bookingID FROM bookings WHERE eventID = :eventID AND userID = :userID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getUserBookings(object $pdo, int $userID) { // FOR SOME REASON THREW AN ERROR AS STRING AS THE USERID????
    $query = "SELECT * FROM bookings WHERE userID = :userID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function createBooking(object $pdo, string $userID, string $eventID) {
    $query = "INSERT INTO bookings (userID, eventID) VALUES (:userID, :eventID);";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();
}

function deleteBooking(object $pdo, int $userID, int $eventID) {
    $query = "DELETE FROM bookings WHERE userID = :userID AND eventID = :eventID";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();
}