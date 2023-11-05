<?PHP

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";
        require_once "login_model.inc.php";
        require_once "login_controller.inc.php";

        // ERROR HANDLERS
        $errors = [];

        if (isInputEmpty($email, $pwd)) {
            $errors["emptyInput"] = "Please fill in all the fields!";
        }

        $result = getUser($pdo, $email);

        if (isEmailWrong($result)) {
            $errors["loginIncorrect"] = "Incorrect login information email!";
        }

        if (!isEmailWrong($result) && isPasswordWrong($pwd, $result["pwd"])) {
            $errors["login"] = "Incorrect login information password!";
        }
        
        require_once "config_session.inc.php";

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
        $_SESSION["userEmail"] = htmlspecialchars($result["email"]);
        
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