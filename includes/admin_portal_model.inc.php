<?php

declare(strict_types=1);

function setEvent(object $pdo, string $eventName, string $eventDescription, string $eventHost, string $eventImage, string $eventCapacity, string $eventTime, string $eventDate) {
    $query = "INSERT INTO events (name, description, host, image, capacity, eventTime, eventDate) VALUES (:name, :description, :host, :image, :capacity, :eventTime, :eventDate);";
    $statement = $pdo->prepare($query);

    $statement->bindValue("name", $eventName);
    $statement->bindValue("description", $eventDescription);
    $statement->bindValue("host", $eventHost);
    $statement->bindValue("image", $eventImage);
    $statement->bindValue("capacity", $eventCapacity);
    $statement->bindValue("eventTime", $eventTime);
    $statement->bindValue("eventDate", $eventDate);
    
    $statement->execute();

}