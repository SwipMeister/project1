<?php

?>

<html>

<head>
    <title>INLOGFORM</title>
</head>

<body>
<fieldset>
    <h3>Wachtwoord herstellen</h3>
        <form action="restorepw.php" method="post">
            <label for="email">email:</label><br> <!-- required="required"-->
            <input required type="email"  name="email"><br> <!-- required="required"-->
            <label for="email">Bevestig email:</label><br> <!-- required="required"-->
            <input required type="email"  name="email"><br> <!-- required="required"-->
            <button type="submit" name="recover" value="recover">Recover</button><br>
            <a href="signup.php">Heb je nog geen account? Registreer nu</a><br>
            <a href="index.php">Terug naar het begin</a><br>
        </form>
        </fieldset>
</body>

</html>
