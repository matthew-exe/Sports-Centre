<?php

declare (strict_types= 1);

function getUser(object $pdo, string $username) {
    $query = "SELECT * FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("username", $username);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}
