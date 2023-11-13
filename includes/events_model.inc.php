<?php

declare (strict_types= 1);

function getEvents(object $pdo) {
    $query = "SELECT * FROM events";
    $statement = $pdo->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSpecificEvent(object $pdo, int $eventID) { // dont really know why it wants a int
    $query = "SELECT * FROM events WHERE eventID = :eventID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("eventID", $eventID);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}
