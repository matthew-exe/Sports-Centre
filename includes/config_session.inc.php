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

if (!isset($_SESSION["last_regeneration"])) { // if first time making session
    regenerate_session_id();
}
else {
    $interval = 60 * 30; // setting the interval to be 60 seconds times 30 (30 minutes)

    if (time() - $_SESSION["last_regeneration"] >= $interval) { // if it has been more than 30 minutes since regenerating id
        regenerate_session_id();
    }
}

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}