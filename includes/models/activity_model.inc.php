<?php

class ActivityModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getActivityById($activityID) {
        $query = "SELECT * FROM activities WHERE activity_id = :activity_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function countBookingsForActivity($activityID) {
        $query = "SELECT COUNT(*) as booking_count FROM bookings WHERE activity_id = :activity_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['booking_count'];
    }

    public function getTotalActivitiesCount($dateFilter = "", $search = "", $filters = []) {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";
    
        $bookingCondition = "";
        if (in_array("notfullybooked", $filters)) {
            $bookingCondition = " AND (SELECT COUNT(*) FROM bookings WHERE bookings.activity_id = activities.activity_id) < activities.capacity";
        }
    
        $query = "SELECT COUNT(*) AS total FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search $bookingCondition;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":dateFilter", $dateValue);
        $statement->bindValue(":search", $searchValue);
        $statement->execute();
    
        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getActivitiesPaginated($perPage, $offset, $dateFilter = "", $search = "", $filters = []) {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";
    
        $bookingCondition = "";
        if (in_array("notfullybooked", $filters)) {
            $bookingCondition = " AND (SELECT COUNT(*) FROM bookings WHERE bookings.activity_id = activities.activity_id) < activities.capacity";
        }
    
        if (in_array("closestdate", $filters)) {
            $query = "SELECT * FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search $bookingCondition ORDER BY activity_date ASC LIMIT :perPage OFFSET :offset;";
        } else {
            $query = "SELECT * FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search $bookingCondition LIMIT :perPage OFFSET :offset;";
        }
    
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":dateFilter", $dateValue);
        $statement->bindValue(":search", $searchValue);
        $statement->bindParam(":perPage", $perPage, PDO::PARAM_INT);
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->execute();
    
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUserBookedActivitiesCount($userID, $dateFilter = "", $search = "") {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";

        $query = "SELECT COUNT(*) AS total FROM activities 
                  INNER JOIN bookings ON activities.activity_id = bookings.activity_id 
                  WHERE bookings.user_id = :user_id
                  AND activities.activity_date LIKE :dateFilter 
                  AND activities.name LIKE :search;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":user_id", $userID);
        $statement->bindValue(":dateFilter", $dateValue);
        $statement->bindValue(":search", $searchValue);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUserBookedActivitiesPaginated($userID, $perPage, $offset, $dateFilter = "", $search = "") {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";

        $query = "SELECT activities.* FROM activities 
                  INNER JOIN bookings ON activities.activity_id = bookings.activity_id 
                  WHERE bookings.user_id = :user_id
                  AND activities.activity_date LIKE :dateFilter 
                  AND activities.name LIKE :search 
                  LIMIT :perPage OFFSET :offset;";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":user_id", $userID);
        $statement->bindValue(":dateFilter", $dateValue);
        $statement->bindValue(":search", $searchValue);
        $statement->bindParam(":perPage", $perPage, PDO::PARAM_INT);
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createActivity($activityName, $shortDescription, $longDescription, $activityHost, $activityImage, $activityCapacity, $activityTime, $activityDate) {
        $query = "INSERT INTO activities (name, short_description, long_description, host, image, capacity, activity_time, activity_Date) VALUES (:name, :short_description, :long_description, :host, :image, :capacity, :activity_time, :activity_date);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("name", $activityName);
        $statement->bindValue("short_description", $shortDescription);
        $statement->bindValue("long_description", $longDescription);
        $statement->bindValue("host", $activityHost);
        $statement->bindValue("image", $activityImage);
        $statement->bindValue("capacity", $activityCapacity);
        $statement->bindValue("activity_time", $activityTime);
        $statement->bindValue("activity_date", $activityDate);
        $statement->execute();
    }

    public function updateActivity($activityID, $activityName, $shortDescription, $longDescription, $activityHost, $activityImage, $activityCapacity, $activityTime, $activityDate) {
        $query = "UPDATE activities SET name = :name, short_description = :short_description, long_description = :long_description, host = :host, image = :image, capacity = :capacity, activity_time = :activity_time, activity_date = :activity_date WHERE activity_id = :activity_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("activity_id", $activityID);
        $statement->bindValue("name", $activityName);
        $statement->bindValue("short_description", $shortDescription);
        $statement->bindValue("long_description", $longDescription);
        $statement->bindValue("host", $activityHost);
        $statement->bindValue("image", $activityImage);
        $statement->bindValue("capacity", $activityCapacity);
        $statement->bindValue("activity_time", $activityTime);
        $statement->bindValue("activity_date", $activityDate);
        $statement->execute();
    }

    public function deleteActivity($activityID) {
        $query = "DELETE FROM activities WHERE activity_id = :activity_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("activity_id", $activityID);
        $statement->execute();
    }
}