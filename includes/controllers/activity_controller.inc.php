<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/Web-Programming/includes/models/activity_model.inc.php";

class ActivityController extends ActivityModel {

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

}