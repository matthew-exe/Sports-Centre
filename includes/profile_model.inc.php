<?php

function getUser(object $pdo, string $userID) {
    $query = "SELECT * FROM users WHERE userID = :userID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateFirstname(object $pdo, string $userID, string $firstname) {
    $query = "UPDATE users SET firstname = :firstname WHERE userID = :userID;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("firstname", $firstname);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}

function updateSurname(object $pdo, string $userID, string $surname) {
    $query = "UPDATE users SET surname = :surname WHERE userID = :userID;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("surname", $surname);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}

function updateEmail(object $pdo, string $userID, string $email) {
    $query = "UPDATE users SET email = :email WHERE userID = :userID;";
    $statement = $pdo->prepare($query);

    $statement->bindValue("email", $email);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}

function updatePassword(object $pdo, string $userID, string $pwd) {
    $query = "UPDATE users SET pwd = :pwd WHERE userID = :userID;";
    $statement = $pdo->prepare($query);

    $options = [
        "cost" => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);


    $statement->bindValue("pwd", $hashedPwd);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}
