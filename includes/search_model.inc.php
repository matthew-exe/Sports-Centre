<?php 

declare(strict_types=1);

function searchEvents(object $pdo, string $search) {
    $search = '%' . $search . '%';
    $query = "SELECT * FROM events WHERE name LIKE :search OR description LIKE :search;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("search", $search);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}