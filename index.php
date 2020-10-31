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

    print_r(session_status());



?>

<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Log in!</title>
</head>

<body>
<fieldset>
    <form align="center" action="index.php" method="post" id="login">
        <h3>Login</h3>
        <span class="text-danger"><?php echo (!empty($loginStatus) && $loginStatus != '') ? $loginStatus ."<br>": ''  ?></span> 
                <label for="username">Username:</label><br> <!-- required="required"-->
                <input required type="text" name="username" id="username" pattern="[a-z]{1,15}+@"    ><br> <!-- required="required"-->
                <label for="password" >Password:</label><br>
                <input required type="password" name="password" id="password" minlength="10" maxlength="20">
                <br><br>
                <button class="btn btn-secondary" type="submit" name="login" value="Login">Login</button><br    >
            </form>
        </fieldset>
    <div align="center">
        <a class="btn btn-secondary" href="signup.php">Aanmelden</a>
        <a class="btn btn-secondary" href="lostpsw.php">Wachtwoord vergeten?</a>
    </div>
</body>

</html>