<?php

class BookingModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function getBooking($activityID, $userID) {
        $query = "SELECT activity_id FROM bookings WHERE activity_id = :activity_id AND user_id = :user_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("user_id", $userID);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function isActivityFull($activityID) {
        // Counting the bookings of the activity
        $query = "SELECT COUNT(*) as booking_count FROM bookings WHERE activity_id = :activity_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    
        // Getting the capacity of the activity
        $queryCapacity = "SELECT capacity FROM activities WHERE activity_id = :activity_id;";
        $statementCapacity = $this->pdo->prepare($queryCapacity);
        $statementCapacity->bindValue("activity_id", $activityID);
        $statementCapacity->execute();
    
        $capacityResult = $statementCapacity->fetch(PDO::FETCH_ASSOC);
    
        // Check if the count of bookings is equal to or greater than the capacity
        return ($result['booking_count'] >= $capacityResult['capacity']);
    }
    
    function createBooking($activityID, $userID) {
        $query = "INSERT INTO bookings (user_id, activity_id) VALUES (:user_id, :activity_id);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("user_id", $userID);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    }
    
    function deleteBooking($activityID, $userID) {
        $query = "DELETE FROM bookings WHERE user_id = :user_id AND activity_id = :activity_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("userID", $userID);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    }
}