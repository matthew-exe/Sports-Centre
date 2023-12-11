<?php
require_once "includes/models/user_model.inc.php";

class UserController extends UserModel {

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    function isSignupInputEmpty($firstname, $surname, $email, $pwd) {
        if (empty($firstname) || empty($surname) || empty($email) || empty($pwd)) {
            return true;
        }
        else {
            return false;
        }
    }

    function isLoginInputEmpty($email, $pwd) {
        if (empty($email) || empty($pwd)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function isEmailInvalid($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function isEmailRegistered($email) {
        if ($this->getEmail($email)) {
            return true;
        }
        else {
            return false;
        }
    }

    function isPasswordValid($pwd) {
        $uppercase = preg_match('@[A-Z]@', $pwd);
        $lowercase = preg_match('@[a-z]@', $pwd);
        $number = preg_match('@[0-9]@', $pwd);
    
        if ($uppercase && $lowercase && $number && 8 < strlen($pwd)) {
            return false;
        }
        else {
            return true;
        }
    }

    function isPasswordCorrect($pwd, $hashedPwd) {
        if  (password_verify($pwd, $hashedPwd)) {
            return true;
        } 
        else {
            return false;
        }
    }

    
}
