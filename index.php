<?php
    include 'db.php';
    include 'helper.php';

    $username = '';
    $password = '';
    // check if form is actually from the POST method
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

        // array for fieldnames
        $fieldnames = ['username', 'password'];

        // helper class instantieren
        $validator = new Helper();
        // functie field_validator aanroepen en in een variabele gezet zodat hier later mee gewerkt kan worden
        $fields_are_validated = $validator->field_validator($fieldnames);

        // if field_validation returns TRUE -> set $_POST variabelen

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // database instantieren
        $db = new Database('localhost', 'project1', 'root', '',  'utf8');
          
        // function login (db.php) heeft error messages voor beide error voor beide scenarios
        $loginStatus = $db->login($username, $password);


    }



?>

<html>
    
<head>
<style>
        .error {color: red; font-weight: bold;}
        .success {margin-bottom:30px; font-weight: bold;}
        /* form { text-align:center;} */
    </style>
    <title>Log in!</title>
</head>

<body>
<fieldset>
            <h3>Login</h3>
            <span class="error"><?php echo (!empty($loginStatus) && $loginStatus != '') ? $loginStatus . "<br>": ''  ?></span> 
            <form action="index.php" method="post" id="login">
                <label for="username">Username:</label><br> <!-- required="required"-->
                <input required type="text" name="username" id="username" pattern="[a-z]{1,15}+@"    ><br> <!-- required="required"-->
                <label for="password" >Password:</label><br>
                <input required type="password" name="password" id="password" minlength="10" maxlength="20">
                <br><br>
                <button type="submit" name="login" value="Login">Login</button><br>
                <a href="signup.php">Heb je nog geen account? Registreer nu</a><br>
                <a href="lostpsw.php">Wachtwoord vergeten?</a>
            </form>
</fieldset>
</body>

</html>