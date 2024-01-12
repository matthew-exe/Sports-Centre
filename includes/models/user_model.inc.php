<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // Managing users funcitons

    public function getEmail($email)
    {
        $query = "SELECT email FROM users WHERE email = :email;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("email", $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserFromEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("email", $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserFromID($userID)
    {
        $query = "SELECT * FROM users WHERE user_id = :user_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("user_id", $userID);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserGroup($userID)
    {
        $query = "SELECT groups.group_name
                  FROM group_users
                  INNER JOIN groups ON group_users.group_id = groups.group_id
                  WHERE group_users.user_id = :user_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(":user_id", $userID);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function updateUser($attributeToUpdate, $updatedValue, $userID)
    {
        $query = "UPDATE users SET $attributeToUpdate = :updatedValue WHERE user_id = :user_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("updatedValue", $updatedValue);
        $statement->bindValue("user_id", $userID);
        $statement->execute();
    }


    public function updatePwd($pwd, $userID)
    {
        $query = "UPDATE users SET pwd = :hashedPwd WHERE user_id = :user_id;";
        $statement = $this->pdo->prepare($query);

        $options = [
            "cost" => 12
        ];

        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
        $statement->bindValue("hashedPwd", $hashedPwd);
        $statement->bindValue("user_id", $userID);
        $statement->execute();
    }

    public function createUser($firstname, $surname, $email, $pwd) {
        $query = "INSERT INTO users (firstname, surname, email, pwd) VALUES (:firstname, :surname, :email, :pwd);";
        $statement = $this->pdo->prepare($query);

        $options = [
            "cost" => 12
        ];

        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
        $statement->bindValue("firstname", $firstname);
        $statement->bindValue("surname", $surname);
        $statement->bindValue("email", $email);
        $statement->bindValue("pwd", $hashedPwd);
        $statement->execute();

        return $this->pdo->lastInsertId();
    }

    public function setUserGroup($userID, $groupID)
    {
        $query = "INSERT INTO group_users (user_id, group_id) VALUES (:user_id, :group_id);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("user_id", $userID);
        $statement->bindValue("group_id", $groupID);
        $statement->execute();
    }

    public function deleteUser($userID)
    {
        $query = "DELETE FROM users WHERE user_id = :user_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("user_id", $userID);
        $statement->execute();
    }

    // Displaying Users for Admin Portal

    public function getTotalUsersCount($search = "")
    {
        $searchValue = "%$search%";

        $query = "SELECT COUNT(*) AS total FROM users 
        WHERE (users.user_id LIKE :search 
        OR users.firstname LIKE :search 
        OR users.surname LIKE :search 
        OR users.email LIKE :search)
        ";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":search", $searchValue);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUsersPaginated($perPage, $offset, $search = "")
    {
        $searchValue = "%$search";

        $query = "SELECT users.*, groups.group_name 
              FROM users 
              LEFT JOIN group_users ON users.user_id = group_users.user_id
              LEFT JOIN groups ON group_users.group_id = groups.group_id
              WHERE (users.user_id LIKE :search 
                     OR users.firstname LIKE :search 
                     OR users.surname LIKE :search 
                     OR users.email LIKE :search)
              LIMIT :perPage OFFSET :offset";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":search", $searchValue);
        $statement->bindParam(":perPage", $perPage, PDO::PARAM_INT);
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Displaying users that have booked an activity

    public function getTotalUsersBookedForActivityCount($activityID, $search = "") {
        $searchValue = "%$search%";

        $query = "SELECT COUNT(*) AS total FROM users 
              INNER JOIN bookings ON users.user_id = bookings.user_id 
              WHERE bookings.activity_id = :activity_id
              AND (users.firstname LIKE :search OR users.surname LIKE :search OR users.email LIKE :search);";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":activity_id", $activityID);
        $statement->bindValue(":search", $searchValue);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUsersBookedForActivityPaginated($activityID, $perPage, $offset, $search = "") {
        $searchValue = "%$search%";

        $query = "SELECT users.* FROM users
              INNER JOIN bookings ON users.user_id = bookings.user_id 
              WHERE bookings.activity_id = :activity_id
              AND (users.firstname LIKE :search OR users.surname LIKE :search OR users.email LIKE :search)
              LIMIT :perPage OFFSET :offset;";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":activity_id", $activityID);
        $statement->bindValue(":search", $searchValue);
        $statement->bindParam(":perPage", $perPage, PDO::PARAM_INT);
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
