<?php


?>

<html>

<head>
    <title>INLOGFORM</title>
</head>

<body>
<fieldset>
            <h3>Login</h3>
            <form action="login.php" method="post" id="login">
                <label for="username">Username:</label><br> <!-- required="required"-->
                <input required type="text" name="username" id="username" pattern="[a-z]{1,15}+@"    ><br> <!-- required="required"-->
                <label for="password" >Password:</label><br>
                <input required type="password" name="password" id="password" minlength="10" maxlength="20">
                <br><br>
                <button type="submit" name="Login" value="Login">Login</button><br>
                <a href="signup.php">Heb je nog geen account? Registreer nu</a><br>
                <a href="lostpsw.php">Wachtwoord vergeten?</a>
            </form>
        </fieldset>
</body>

</html>