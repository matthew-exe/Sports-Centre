<?PHP

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";
        require_once "login_model.inc.php";
        require_once "login_controller.inc.php";

        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($username, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        $result = getUser($pdo, $username);

        if (isUsernameWrong($result)) {
            $errors["loginIncorrect"] = "Incorrect login information!";
        }

        if (!isUsernameWrong($result) && isPasswordWrong($pwd, $result["pwd"])) {
            $errors["login"] = "Incorrect login information!";
        }
        
        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["loginErrors"] = $errors;

            header("Location: ../login.php");
            die();
        }

        if ($errors) {
            $_SESSION["loginErrors"] = $errors;

            header("Location: ../login.php");
            die();
        }


        
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);
        $_SESSION["lastRegeneration"] = time();

        $_SESSION["userId"] = $result["id"];
        $_SESSION["userUsername"] = htmlspecialchars($result["username"]);
        
        header("Location: ../login.php?login=success");
        $statement = null;
        $pdo = null;

        die();
    }
    catch (PDOException $e) {
        die("Quesry failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../index.php");
    die();
}