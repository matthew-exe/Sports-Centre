<?php

function getUser(object $pdo, string $id) {
    $query = "SELECT * FROM users WHERE id = :id;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("id", $id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateFirstname(object $pdo, string $id, string $firstname) {
    $query = "UPDATE users SET firstname = :firstname WHERE id = :id;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("firstname", $firstname);
    $statement->bindValue("id", $id);
    $statement->execute();
}

function updateSurname(object $pdo, string $id, string $surname) {
    $query = "UPDATE users SET surname = :surname WHERE id = :id;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("surname", $surname);
    $statement->bindValue("id", $id);
    $statement->execute();
}

function updateEmail(object $pdo, string $id, string $email) {
    $query = "UPDATE users SET email = :email WHERE id = :id;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("email", $email);
    $statement->bindValue("id", $id);
    $statement->execute();
}

function updatePassword(object $pdo, string $id, string $pwd) {
    $query = "UPDATE users SET pwd = :pwd WHERE id = :id;";
    $statement = $pdo->prepare($query);

    $options = [
        "cost" => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);


    $statement->bindValue("pwd", $hashedPwd);
    $statement->bindValue("id", $id);
    $statement->execute();
}
