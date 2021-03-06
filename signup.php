<?php
    
    include 'db.php';
    include 'helper.php';

    $voornaam = $achternaam = $tussenvoegsel = $email = $username = $password = $pwFail = $pwSuccess = $msg = "";
    // als form geen post action heeft gebeurd er niets.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['register']))) {
        $fieldnames = ['voornaam', 'achternaam', 'email', 'username', 'password', 'repassword' ];
        
        $error = False; // 0

        // instantieer Helper class
        $val = new Helper();

        // roep functie field_validator uit class Helper aan, zit in een variabele zodat we er mee kunnen werken
        $fields_are_validated = $val->field_validator($fieldnames);

        // functie field_validator returnt een true of false
        // if true --> sla user value op in $_POST variabelen
        if ($fields_are_validated) {

          //inputs trimmen naar lowercase
          
          $username = trim(strtolower($_POST['username']));
          $password = trim(strtolower($_POST['password']));

          $voornaam = trim(strtolower($_POST['voornaam']));
          $tussenvoegsel = isset($_POST['tussenvoegsel']) ? trim(strtolower($_POST['tussenvoegsel'])) : NULL;    
          $achternaam = trim(strtolower($_POST['achternaam']));
          $email = trim(strtolower($_POST['email']));
          $repassword = trim(strtolower($_POST['repassword']));


        if ($_POST["password"] === $_POST["repassword"]) {

          // database instantieren
          $db = new Database('localhost', 'project1', 'root', '',  'utf8');
          
          // $db::USER pakt USER (2) constant uit db.php 
          
          $msg = $db->signup($username, $voornaam, $tussenvoegsel, $achternaam, $email, $db::USER, $password);
          // $account_id = $db->alterAccount($username, $email, $password);
          // $db->alterPersoon($voornaam, $tussenvoegsel, $achternaam, $email, $account_id);
          
          
        }else {
            // error message in variabele die naast het herhaalde password field plaatsvind
            $pwFail = "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";

            $error = True;

          } 
        }
    }

    
    ?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Signupform</title>
</head>

<body>
<fieldset>
  <form align="center" action="signup.php" method="post">
    <h3>Sign-up</h3>
                <label for="voornaam">Voornaam:</label><br>
                <input required type="text" name="voornaam" id="voornaam" value="<?php echo isset($_POST['voornaam']) ? htmlentities($_POST['voornaam']) : ''; ?>" ><span class="text-danger">*</span><br>
                <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo isset($_POST['tussenvoegsel']) ? htmlentities($_POST['tussenvoegsel']) : ''; ?>"><br>
                <label for="achternaam" >Achternaam:</label><br>
                <input required type="text" name="achternaam" id="achternaam" value="<?php echo isset($_POST['achternaam']) ? htmlentities($_POST['achternaam']) : ''; ?>"><span class="text-danger">*</span><br>
                <label for="email">E-mail:</label><br>
                <input required type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>"><span class="text-danger"></span><br>
                <label for="username">Username:</label><br>
                <input required pattern="[a-z]{1,15}+@" type="text"  name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlentities($_POST['username']) : ''; ?>"><span class="text-danger">*</span><br>
                <label for="password" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password" id="password"><span class="text-danger">*</span><br>
                <label for="repassword" >Repeat Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="repassword" id="password"> <span class="text-danger">*<?php if($pwFail) echo $pwFail;?></span><br>
                <br><span class="text-success"><?php if($msg) echo $msg; ?></span>
                <br><span class="text-success"><?php if($pwSuccess) echo $pwSuccess; ?></span>
                <button class="btn btn-secondary" type="submit" name="register" value="Register">Register</button><br>
                <a class="btn btn-secondary" href="index.php">Terug naar het begin</a>
    </form> 
</fieldset>
</body>

</html>




<!-- field validation omslachtig

    $voornaamErr = $achternaamErr = $emailErr = $usernameErr = $passwordErr = $pwMatch = $success = "";
     if($pwMatch) echo $pwMatch;?>
    //TODO: foreach toepassen ipv losse if statements
    // als form geen post action heeft gebeurd er niets.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // tussenvoegsel optioneel

      if ($_POST["password"] === $_POST["repassword"]) {
        $success = "Registratie succesvol";
        // TODO: redirect succcespage/login
        header("refresh:5;url=index.php");
        echo "Registratie succesvol. U wordt geredirect naar de inlog pagina.";
        die();
      }elseif ($_POST["password"] !== $_POST["repassword"]) {
          $pwMatch = "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";
          header('Location: signup.php');
          echo "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in"ð;

          die(); //exit()

      } 

      if (empty($_POST["voornaam"])) {
        $voornaamErr = "Voornaam is verplicht";
      } else {
        $voornaam = ($_POST["voornaam"]);
      }
      
      if (empty($_POST["achternaam"])) {
        $achternaamErr = "Achternaam is verplicht";
      } else {
        $achternaam = ($_POST["achternaam"]);
      }
      
      if (empty($_POST["email"])) {
        $emailErr = "Email is verplicht";
      } else {
        $email = ($_POST["email"]);
      }
      
      if (empty($_POST["username"])) {
        $usernameErr = "Username is verplicht";
      } else {
        $username = ($_POST["username"]);
      }
      
      if (empty($_POST["password"])) {
        $passwordErr = "Password is verplicht";
      } else {
        $password = ($_POST["password"]);
      }
      
      if (empty($_POST["repassword"])) {
        $passwordErr = "Vul je wachtwoord in";
      } else {
        $password = ($_POST["repassword"]);
      }
      $tussenvoegsel = $_POST['tussenvoegsel'];
      
    } -->