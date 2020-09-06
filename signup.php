<?php


?>

<html>

<head>
    <title>Signupform</title>
</head>

<body>
<fieldset>
            <h3>Sign-up</h3>
            <form action="register.php" method="post">
                <label for="voornaam">Voornaam:</label><br> <!-- required="required"-->
                <input type="text" name="voornaam" required  id="voornaam" ><br> <!-- required="required"-->
                <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
                <input required type="text" name="tussenvoegsel"><br>
                <label for="achternaam" >Achternaam:</label><br>
                <input required type="text" name="achternaam"><br>
                <label for="email">email:</label><br> <!-- required="required"-->
                <input required type="email"  name="email"><br> <!-- required="required"-->
                <label for="username">Username:</label><br> <!-- required="required"-->
                <input pattern="[a-z]{1,15}" required type="text"  name="username"><br> <!-- required="required"-->
                <label for="password" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password"><br>
                <label for="repassword" >Repeat Password:</label><br>
                <input required minlength="10" maxlength="20" type="repassword" name="repassword"><br>
                <br>
                <button type="submit" name="Register" value="Register">Register</button><br>
                <a href="index.php">Terug naar het begin</a><br>
            </form>
        </fieldset>
</body>

</html>