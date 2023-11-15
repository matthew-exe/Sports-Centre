<?php

declare (strict_types= 1);

function getUser(object $pdo, string $email) {
    $query = "SELECT * FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("email", $email);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getUserGroup(object $pdo, string $userID) {
    $query = "SELECT groups.groupName
    FROM groups, group_users
    WHERE group_users.userID = :userID
         and groups.groupID = group_users.groupID;";
    $statement = $pdo->prepare($query);
    $statement->bindValue("userID", $userID);
    $statement->execute();

    return $statement->fetchColumn();
}