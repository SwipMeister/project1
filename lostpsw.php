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
            <label for="email">email:</label><br> <!-- required="required"-->
            <input required type="email"  name="email"><br> <!-- required="required"-->
            <label for="reemail">Bevestig email:</label><br> <!-- required="required"-->
            <input required type="reemail"  name="reemail"><br> <!-- required="required"-->
            <a href="signup.php">Heb je nog geen account? Registreer nu</a><br>
            <a href="index.php">Terug naar het begin</a><br>
        </form>
        </fieldset>
</body>

</html>
