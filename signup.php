<?php
    
    include 'db.php';


    $voornaam = $achternaam = $tussenvoegsel = $email = $username = $password = $errorMsg = $pwFail = $pwSuccess = "";
    // als form geen post action heeft gebeurd er niets.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!isset($_POST['submit'])) {
        $fieldnames = ['voornaam', 'achternaam', 'email', 'username', 'password', 'repassword' ];
        
        $error = False; // 0
        // foreach om te loopen door de fieldnames, als  deze niet gezet zijn 
        foreach ($fieldnames as $fieldname) {
          if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
            $error = True; // 1
            $errorMsg = "* Velden met een ster/asteriks zijn verplicht.";
            echo 'Error heeft zich voorgedragen, velden zijn leeg.';
          }
        }
        if ($_POST["password"] === $_POST["repassword"]) {
          $pwSuccess = "Registratie succesvol. U wordt geredirect naar de inlog pagina.";
          // TODO: redirect succcespage/login
          // header("refresh:5;url=index.php");
          // die();
        }elseif ($_POST["password"] !== $_POST["repassword"]) {
            $pwFail = "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";
            // header('Location: signup.php');
            // echo "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";
            $error = True;
            // die();
            // exit()
  
        } 

          // check of error zich heeft voor gedaan (if not true, dus false)
        if (!$error) { // ($error !== TRUE)
        $voornaam = $_POST['voornaam'];
        $username = $_POST['username'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        $db = new Database('localhost', 'project1', 'root', '',  'utf8');
        $account_id = $db->insertAccount($username, $email, $password);
        $db->insertPersoon($voornaam, $tussenvoegsel, $achternaam, $email, $account_id);

        }
      }
  }

    
    ?>

<html>

<head>
    <title>Signupform</title>
    <style>
        .error {color: red; font-weight: bold;}
        .success {margin-bottom:30px; font-weight: bold;}
    </style>
</head>

<body>
<fieldset>
            <h3>Sign-up</h3>
            <form action="signup.php" method="post">
                <label for="voornaam">Voornaam:</label><br>
                <input required type="text" name="voornaam" id="voornaam" ><span class="error">*</span><br>
                <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel"><br>
                <label for="achternaam" >Achternaam:</label><br>
                <input required type="text" name="achternaam" id="achternaam"><span class="error">*</span><br>
                <label for="email">E-mail:</label><br>
                <input required type="email" name="email" id="email"><span class="error"></span><br>
                <label for="username">Username:</label><br>
                <input required pattern="[a-z]{1,15}+@" type="text"  name="username" id="username"><span class="error">*</span><br>
                <label for="password" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password" id="password"><span class="error">*</span><br>
                <label for="repassword" >Repeat Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="repassword" id="password"> <span class="error">*<?php if($pwFail) echo $pwFail;?></span><br>
                <br><span class="success"><?php if($pwSuccess) echo $pwSuccess;?></span><br>
                <button type="submit" name="Register" value="Register">Register</button><br>
                <a href="index.php">Terug naar het begin</a><br>
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