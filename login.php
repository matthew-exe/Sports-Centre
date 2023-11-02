<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website - Login</title>
    <link rel="icon" href="logo.svg" type="image/x-icon"/>
    <link rel="stylesheet" href="styles.css"> <!-- If you have an external stylesheet -->
</head>


<div class="navbar">
    <ul>
        <li>
            <a href="index.php">
            <img 
            src="logo.svg"
            alt="Logo"
            height=80px
            width=80px />
            </a>
        </li>
        <li><a id="navbarButtons" href="login.php">Login</a></li>
        <li><a id="navbarButtons" href="signup.php">Sign up</a></li>
    </ul>
</div>

<body>
    <div class="registrationForms" id="loginForm">
        <form action="/login-inc.php">
            <input type="text" id="email" name="email" placeholder="Email" required><br>
            <input type="text" id="password" name="password" placeholder="Password" required><br><br>
            <input type="submit" value="Login">
          </form> 
    </div>
</body>

</html>