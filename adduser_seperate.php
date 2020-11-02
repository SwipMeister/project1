<?php

include 'db.php';
include 'helper.php';


// TODO:session start 
session_start();
$msg = $msg_update = '';
    // zorgt ervoor dat pagina niet via URL te vinden is. 
    if(isset($_SESSION['username']) && $_SESSION['username'] == true){

        $_SESSION['loggedin'] = true;

    }else {
        echo 'U bent niet ingelogd.';

        header("refresh:3;url=index.php");
        exit;
    }
    
    $db = new Database('localhost', 'project1', 'root', '',  'utf8');
    $val = new Helper();

if ($_SERVER["REQUEST_METHOD"] == "POST" &&  (isset($_POST['addUser']))) {
        echo 'check';
        // sleep(3);
        print_r($_POST);
        // komt hier niet
        $fieldnames = [ 'type', 'username', 'email', 'password', 'voornaam', 'achternaam' ]; // password is optional
            
        $fields_are_validated = $val->field_validator($fieldnames);

        // functie field_validator returnt een true of false
        // if true --> sla user value op in $_POST variabelen
        if ($fields_are_validated) {

            // admin/user (1/2)
            $type = $_POST['type'];

            //inputs trimmen naar lowercase
            $username = trim(strtolower($_POST['username']));
            $email = trim(strtolower($_POST['email']));
            $password = trim(strtolower($_POST['password']));
            
            $voornaam = trim(strtolower($_POST['voornaam']));
            $tussenvoegsel = isset($_POST['tussenvoegsel']) ? trim(strtolower($_POST['tussenvoegsel'])) : NULL;    
            $achternaam = trim(strtolower($_POST['achternaam']));
            

            echo 'hallo';
            $msg = $db->signup($username, $voornaam, $tussenvoegsel, $achternaam, $email, $type, $password);
            
            echo $msg;
        }

    }

?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Add user</title>
</head>

<body>
<div align="center">
        <h3>Admin panel</h3>
        <p>Ingelogd als: <span style="font-weight:bold;"><?= $_SESSION["username"] ?></span></p>
        <a class="btn btn-secondary" href="welcome_admin.php">Home</a> |
        <a class="btn btn-secondary" href="adduser_seperate.php">Add/Edit user</a> |
        <a class="btn btn-secondary" href="edit_user.php">View, edit or delete user</a> |
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
<fieldset>
  <form align="center" action="adduser_seperate.php" method="post">
    <h3>Add user</h3>
    <div class="form-group">
            <h3> Account gegevens </h3>
            <div class="dropdown">
                <label for="type">User type:</label><br>
            <select name='type' id='type'>
                <option value=2>User</option>
                <option value=1>Admin</option>
            </select>
            </div><br>
            <label for="email">E-mail:</label><br>
            <input required type="email" name="email" id="email" value=""><span class="text-danger"></span><br>
            <label for="username">Username:</label><br>
            <input required pattern="[a-z]{1,15}+@" type="text"  name="username" id="username" value=""><span class="text-danger"></span><br>
            <label for="password" readonly>Password:</label><br>
            <input required readonly  minlength="10" maxlength="20" type="password" name="password" id="password" value="helloworld"><span class="text-danger"></span><br>
            </div>
            <div class="form-group">
            <h3>Persoonsgegevens</h3>
            <label for="voornaam">Voornaam:</label><br>
            <input required type="text" name="voornaam" id="voornaam" value="" ><span class="text-danger"></span><br>
            <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
            <input type="text" name="tussenvoegsel" id="tussenvoegsel" value=""><br>
            <label for="achternaam" >Achternaam:</label><br>
            <input required type="text" name="achternaam" id="achternaam" value=""></span><br>
            </div>

                <button class="btn btn-secondary" type="submit" name="addUser" value="addUser" >Add</button>
                
    </form> 
</fieldset>
</body>

</html>