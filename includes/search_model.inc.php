<?php 

declare(strict_types=1);

function searchEvents(object $pdo, string $search) {
    $search = '%' . $search . '%';
    $query = "SELECT * FROM events WHERE name LIKE :search OR shortDescription LIKE :search OR longDescription LIKE :search;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("search", $search);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchFilterDate(object $pdo, string $dateFilter) {
    $query = "SELECT * FROM events WHERE eventDate = :dateFilter;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("dateFilter", $dateFilter);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchEventsFilterDate(object $pdo, string $search, string $dateFilter) {
    $search = '%' . $search . '%';
    $query = "SELECT * FROM events WHERE (name LIKE :search OR shortDescription LIKE :search OR longDescription LIKE :search) AND eventDate = :dateFilter;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("search", $search);
    $statement->bindValue("dateFilter", $dateFilter);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchEventsSortByDate(object $pdo, string $search) {
    $search = '%' . $search . '%';
    $query = "SELECT * FROM events WHERE (name LIKE :search OR shortDescription LIKE :search OR longDescription LIKE :search) ORDER BY eventDate ASC;;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("search", $search);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function searchSortByDate(object $pdo) {
    $query = "SELECT * FROM events ORDER BY eventDate ASC;;";
    $statement = $pdo->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
