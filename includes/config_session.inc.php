<?php
// setting it to be true  (1 = true)
ini_set("session.use_only_cookies", 1); 
ini_set("session.use_strict_mode", 1); // only use session id we made and make more advanced codes (MANDATORY)

session_set_cookie_params([
    "lifetime" => 1800,
    "domain" => "localhost",
    "path" => "/",
    "secure" => true,
    "httponly" => true,
]);

session_start();

if (isset($_SESSION["userID"])) {
    if (!isset($_SESSION["lastRegeneration"])) { // if first time making session
        regenerateSessionIdLoggedIn();
    }
    else {
        $interval = 60 * 30; // setting the interval to be 60 seconds times 30 (30 minutes)
    
        if (time() - $_SESSION["lastRegeneration"] >= $interval) { // if it has been more than 30 minutes since regenerating id
            regenerateSessionIdLoggedIn();
        }
    }
}
else {
    if (!isset($_SESSION["lastRegeneration"])) { // if first time making session
        regenerateSessionId();
    }
    else {
        $interval = 60 * 30; // setting the interval to be 60 seconds times 30 (30 minutes)
    
        if (time() - $_SESSION["lastRegeneration"] >= $interval) { // if it has been more than 30 minutes since regenerating id
            regenerateSessionId();
        }
    }
}


function regenerateSessionIdLoggedIn() {
    session_regenerate_id(true);

    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $_SESSION["userID"];
    session_id($sessionId);

    $_SESSION["lastRegeneration"] = time();
}

function regenerateSessionId() {
    session_regenerate_id(true);
    $_SESSION["lastRegeneration"] = time();
}