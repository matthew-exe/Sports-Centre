<?php

declare (strict_types= 1);

function getUser(object $pdo, string $email) {
    $query = "SELECT * FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("email", $email);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}
