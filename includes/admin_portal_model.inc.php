<?php

declare(strict_types=1);

function setEvent(object $pdo, string $eventName, string $shortDescription, string $longDescription, string $eventHost, string $eventImage, string $eventCapacity, string $eventTime, string $eventDate) {
    $query = "INSERT INTO events (name, shortDescription, longDescription, host, image, capacity, eventTime, eventDate) VALUES (:name, :shortDescription, :longDescription, :host, :image, :capacity, :eventTime, :eventDate);";
    $statement = $pdo->prepare($query);

    $statement->bindValue("name", $eventName);
    $statement->bindValue("shortDescription", $shortDescription);
    $statement->bindValue("longDescription", $longDescription);
    $statement->bindValue("host", $eventHost);
    $statement->bindValue("image", $eventImage);
    $statement->bindValue("capacity", $eventCapacity);
    $statement->bindValue("eventTime", $eventTime);
    $statement->bindValue("eventDate", $eventDate);
    
    $statement->execute();

}

function getUsers(object $pdo) {
    $query = "SELECT * FROM users";
    $statement = $pdo->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchUsers(object $pdo, string $search) {
    $search = '%' . $search . '%';
    $query = "SELECT * FROM users WHERE firstname LIKE :search OR surname LIKE :search OR email LIKE :search;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("search", $search);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSpecificUser(object $pdo, int $userID) {
    $query = "SELECT * FROM users WHERE userID = :userID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteUserAndRelatedData(object $pdo, int $userID) {
    // Delete bookings associated with the user
    $query = "DELETE FROM users WHERE userID = :userID";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}   