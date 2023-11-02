<?php

declare(strict_types=1); // makes variables have a type

// THIS FILE IS USED FOR QUERYING THE DATABASE

function getUsername(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("username", $username);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getEmail(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("email", $email);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function setUser(object $pdo, string $username, string $email, string $pwd) {
    $query = "INSERT INTO users (username, email, pwd) VALUES (:username, :email, :pwd);";
    $statement = $pdo->prepare($query);

    $options = [
        "cost" => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $statement->bindValue("username", $username);
    $statement->bindValue("email", $email);
    $statement->bindValue("pwd", $hashedPwd);

    $statement->execute();
}