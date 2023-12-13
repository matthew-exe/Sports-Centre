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

    public function getTotalActivitiesCount($dateFilter = "", $search = "", $filters) {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";

        $query = "SELECT COUNT(*) AS total FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":dateFilter", $dateValue);
        $statement->bindValue(":search", $searchValue);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getActivitiesPaginated($perPage, $offset, $dateFilter = "", $search = "", $filters = []) {
        $dateValue = "%$dateFilter%";
        $searchValue = "%$search%";

        if (in_array("closestdate", $filters)) {
            $query = "SELECT * FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search ORDER BY activity_date ASC LIMIT :perPage OFFSET :offset;";
        }
        else {
            $query = "SELECT * FROM activities WHERE activity_date LIKE :dateFilter AND name LIKE :search LIMIT :perPage OFFSET :offset;";
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
}