<?php

declare(strict_types=1);

function isInputEmpty(string $eventName, string $eventDescription, string $eventHost, string $eventImage, string $eventCapacity, string $eventTime, string $eventDate) {
    if (empty($eventName) || empty($eventDescription) || empty($eventHost) || empty($eventImage) || empty($eventCapacity) || empty($eventTime) || empty($eventDate)) {
        return true;
    }
    else {
        return false;
    }
}

function createEvent(object $pdo, string $eventName, string $eventDescription, string $eventHost, string $eventImage, string $eventCapacity, string $eventTime, string $eventDate) {
    setEvent($pdo, $eventName, $eventDescription, $eventHost, $eventImage, $eventCapacity, $eventTime, $eventDate);
}