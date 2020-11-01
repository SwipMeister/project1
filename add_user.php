<?php 
    include 'db.php';
    include 'helper.php';


    // TODO:session start 
    session_start();

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

        // form is om een user toe te voegen, default staat op false, pas als er op edit geklikt wordt wordt dit deel uitgevoerd.
        $user_update_true = false;
        $voornaam = $achternaam = $tussenvoegsel = $password = $msg = "";
        
        if (isset($_GET['account_id']) && isset($_GET['persoon_id'])) {
            
            $user_update_true = true;

            // account
            // account_id meegeven met edit button (edit_user.php)
            $account_id = $_GET['account_id'];
            // returned een assoc array
            $account_details = $db->get_account_details($account_id);
            $username = $account_details['username'];
            $email = $account_details['email'];

            //persoon
            // persoon_id meegeven met edit button (edit_user.php)
            $persoon_id = $_GET['persoon_id'];
            // returned een assoc array
            $persoon_details = $db->get_persoon_details($persoon_id);
            $voornaam = $persoon_details['voornaam'];
            $tussenvoegsel = $persoon_details['tussenvoegsel'];
            $achternaam = $persoon_details['achternaam'];
    
        }

        $input_name = 'addUser';
        
        if(isset($_POST['update'])){
            $input_name = 'update';
        }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST[$input_name]))) {
        $fieldnames = [ 'type', 'username', 'email', 'password', 'voornaam', 'achternaam',  ];
            
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

            if ($input_name == 'addUser' ) {
                echo 'adding user';
                $msg = $db->signup($username, $voornaam, $tussenvoegsel, $achternaam, $email, $type, $password);
                echo 'test';
            }elseif($input_name == 'update'){
                echo 'updating';
                // deze twee arrays geven we mee aan alterUser function
                $account = [
                    'account_id' => $_POST['account_id'],
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'type' => $_POST['type']
                ];

                $persoon = [ 
                    'persoon_id' => $_POST['persoon_id'],
                    'voornaam' => $_POST['voornaam'],
                    'tussenvoegsel' => $_POST['tussenvoegsel'],
                    'achternaam' => $_POST['achternaam'],
                ];

                $db->alterUser($account, $persoon);

                header("refresh:3;url=edit_user.php");
                exit;

            }

        }
    }
?>



<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">      
    <title>User data</title>
</head>

<body>
    <header>

    </header>
<fieldset>
    <div align="center">
        <h3>Add/edit user details</h3>
        <!-- <p>Ingelogd als: <span style="font-weight:bold;"><?= $username ?></span></p> -->
        <a class="btn btn-secondary" href="welcome_admin.php">Home</a> |
        <a class="btn btn-secondary" href="add_user.php">Add/Edit user</a> |
        <a class="btn btn-secondary" href="edit_user.php">View, edit or delete user</a> |
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
</fieldset>

<form align="center" action="add_user.php" method="POST" style="margin-top:30px;">
            <input type="hidden" name="account_id" value="<?php echo isset($_GET['account_id']) ? $_GET['account_id'] : ''; ?>">
            <input type="hidden" name="persoon_id" value="<?php echo isset($_GET['persoon_id']) ? $_GET['persoon_id'] : ''; ?>">
            
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
            <input required type="email" name="email" id="email" value="<?php if(isset($_POST["email"])){ echo htmlentities($_POST["email"]);}elseif($user_update_true){echo $email;}else{echo '';}; ?>"><span class="text-danger"></span><br>
            <label for="username">Username:</label><br>
            <input required pattern="[a-z]{1,15}+@" type="text"  name="username" id="username" value="<?php if(isset($_POST["username"])){ echo htmlentities($_POST["username"]);}elseif($user_update_true){echo $username;}else{echo '';}; ?>"><span class="text-danger"></span><br>
            <label for="password" <?php if($user_update_true){?> hidden <?php } ?>>Password:</label><br>
            <input required <?php if($user_update_true){?> hidden <?php } ?> minlength="10" maxlength="20" type="password" name="password" id="password"><span class="text-danger"></span><br>
            </div>
            <div class="form-group">
            <h3>Persoonsgegevens</h3>
            <label for="voornaam">Voornaam:</label><br>
            <input required type="text" name="voornaam" id="voornaam" value="<?php if(isset($_POST["voornaam"])){ echo htmlentities($_POST["voornaam"]);}elseif($user_update_true){echo $voornaam;}else{echo '';}; ?>" ><span class="text-danger"></span><br>
            <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
            <input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php if(isset($_POST["tussenvoegsel"])){ echo htmlentities($_POST["tussenvoegsel"]);}elseif($user_update_true){echo $tussenvoegsel;}else{echo '';}; ?>"><br>
            <label for="achternaam" >Achternaam:</label><br>
            <input required type="text" name="achternaam" id="achternaam" value="<?php if(isset($_POST["achternaam"])){ echo htmlentities($_POST["achternaam"]);}elseif($user_update_true){echo $achternaam;}else{echo '';}; ?>"><span class="text-danger"></span><br>
            </div>
            <br><span class="text-success"><?php if($msg) echo $msg; ?></span>
            <button class="btn btn-success" type="submit" name="<?php if($user_update_true){echo 'update';}else{echo 'addUser';}?>" value="<?php if($user_update_true){echo 'Update';}else{echo 'Add user';}?>"><?php if($user_update_true){echo 'update';}else{echo 'Add user';}?></button>
        </form>
</body>

</html>


    