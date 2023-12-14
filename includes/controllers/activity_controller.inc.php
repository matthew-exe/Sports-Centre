<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/models/activity_model.inc.php";

class ActivityController extends ActivityModel {

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function isCreateActivityInputEmpty($activityName, $shortDescription, $longDescription, $activityHost, $activityImage, $activityCapacity, $activityTime, $activityDate) {
        if (empty($activityName) || empty($shortDescription) || empty($longDescription) || empty($activityHost) || empty($activityImage) || empty($activityCapacity) || empty($activityTime) || empty($activityDate)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isCapacityNumber($activityCapacity) {
        if (!is_numeric($activityCapacity) || intval($activityCapacity) != $activityCapacity) {
            return true;
        }
        else {
            return false;
        }
    }
}