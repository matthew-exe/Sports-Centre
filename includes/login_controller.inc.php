<?php

declare(strict_types= 1);

function isInputEmpty(string $email, string $pwd) {
    if (empty($email) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmailWrong(array|bool $result) {
    if  (!$result) {
        return true;
    } 
    else {
        return false;
    }
}

function isPasswordWrong(string $pwd, string $hashedPwd) {
    if  (password_verify($pwd, $hashedPwd)) {
        return false;
    } 
    else {
        return true;
    }
}