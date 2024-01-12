<?php
require_once $_SERVER['DOCUMENT_ROOT'] ."/wpassignment/includes/models/booking_model.inc.php";

class BookingController extends BookingModel {

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function isAlreadyBooked($activityID, $userID) {
        if ($this->getBooking($activityID, $userID)) {
            return true;
        }
        else {
            return false;
        }
    }

}
