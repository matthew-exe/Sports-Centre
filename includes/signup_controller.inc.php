<?php
declare(strict_types=1); // makes variables have a type

function isInputEmpty(string $firstname, string $surname, string $email, string $pwd) {
    if (empty($firstname) || empty($surname) || empty($email) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmailInvalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email) {
    if (getEmail($pdo, $email)) {
        return true;
    }
    else {
        return false;
    }
}

function createUser(object $pdo, string $firstname, string $surname, string $email, string $pwd) {
    setUser($pdo, $firstname, $surname, $email, $pwd);
}

