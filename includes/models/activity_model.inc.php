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
}