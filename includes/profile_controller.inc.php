<?php



function isPasswordInputsEmpty(string $currentPassword, string $newPassword, string $confirmPassword) {
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
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

function isPasswordTheSame(string $newPassword, string $confirmPassword) {
    if ($newPassword === $confirmPassword) {
        return true;
    }
    else {
        return false;
    }
}

function isAllDetailsInputsEmpty(string $firstname, string $surname, string $email) {
    if (empty($firstname) && empty($surname) && empty($email)) {
        return true;
    }
    else {
        return false;
    }
}