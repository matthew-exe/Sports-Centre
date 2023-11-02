<?php

declare(strict_types= 1);

function isInputEmpty(string $username, string $pwd) {
    if (empty($username) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}

function isUsernameWrong(array|bool $result) {
    if  (!$result) {
        return true;
    } 
    else {
        return false;
    }
}

function isPasswordWrong(string $pwd, string $hashedPwd) {
    if  (!password_verify($pwd, $hashedPwd)) {
        return true;
    } 
    else {
        return false;
    }
}