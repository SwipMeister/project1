<?php


?>

<html>

<head>
    <title>INLOGFORM</title>
</head>

<body>
<fieldset>
            <h3>Login</h3>
            <form action="login.php" method="post">
                <label for="uname">Username:</label><br> <!-- required="required"-->
                <input pattern="[a-z]{1,15}" required type="text"  name="username"><br> <!-- required="required"-->
                <label for="pword" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password">
                <br><br>
                <button type="submit" name="Login" value="Login">Login</button><br>
                <a href="signup.php">Heb je nog geen account? Registreer nu</a><br>
                <a href="lostpsw.php">Wachtwoord vergeten?</a>
            </form>
        </fieldset>
</body>

</html>