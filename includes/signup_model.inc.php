<?php

declare(strict_types=1); // makes variables have a type

// THIS FILE IS USED FOR QUERYING THE DATABASE


function getEmail(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("email", $email);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function setUser(object $pdo, string $firstname, string $surname, string $email, string $pwd) {
    $query = "INSERT INTO users (firstname, surname, email, pwd) VALUES (:firstname, :surname, :email, :pwd);";
    $statement = $pdo->prepare($query);

    $options = [
        "cost" => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $statement->bindValue("firstname", $firstname);
    $statement->bindValue("surname", $surname);
    $statement->bindValue("email", $email);
    $statement->bindValue("pwd", $hashedPwd);

    $statement->execute();
}

function getUserID(object $pdo, string $email) {
    $query = "SELECT userID FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("email", $email);
    $statement->execute();

    return $statement->fetchColumn();
}

function setGroup(object $pdo, string $userID) {
    $query = "INSERT INTO group_users (groupID, userID) VALUES (1, :userID);";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();
}