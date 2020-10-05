<?php
    
    include 'db.php';

    $db = new db('localhost', 'project1', 'root', '',  'utf8');
    // $db->executeQueryExample;

    // todo check op isset
    // $voornaam = $_POST['voornaam'];
    // $tussenvoegsel = $_POST['tussenvoegsel'];
    // $achternaam = $_POST['achternaam'];
    // $email = $_POST['email'];
    // $username = $_POST['username'];
    // $password = $_POST['password'];
    // $repassword = $_POST['repassword'];

    $voornaam = $achternaam = $email = $username = $password = "";
    $voornaamErr = $achternaamErr = $emailErr = $usernameErr = $passwordErr = $pwMatch = $success = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($_POST["password"] !== $_POST["repassword"]) {
        $pwMatch = "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";
        exit;
      }elseif ($_POST["password"] === $_POST["repassword"]) {
        $success = "Registratie succesvol";
        
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
  
      // TODO: redirect succcespage/login
      // TODO: session start

    }
    
    $db->insertAccount($email, $password);
    
    ?>

<html>

<head>
    <title>Signupform</title>
    <style>
        .error {color: red; font-style: bold;}
    </style>
</head>

<body>
<fieldset>
            <h3>Sign-up</h3>
            <form action="signup.php" method="post">
                <label for="voornaam">Voornaam:</label><br>
                <input required type="text" name="voornaam" id="voornaam" ><span class="error"> *<?= $voornaamErr;?></span><br>
                <label for="tussenvoegsel" >Tussenvoegsel:</label><br>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel"><br>
                <label for="achternaam" >Achternaam:</label><br>
                <input required type="text" name="achternaam" id="achternaam"><span class="error"> *<?= $achternaamErr;?></span><br>
                <label for="email">E-mail:</label><br>
                <input required type="email" name="email" id="email"><span class="error"></span><br>
                <label for="username">Username:</label><br>
                <input required pattern="[a-z]{1,15}+@" type="text"  name="username" id="username"><span class="error"> *<?= $usernameErr;?></span><br>
                <label for="password" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password" id="password"><span class="error"> *<?= $passwordErr;?></span><br>
                <label for="repassword" >Repeat Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="repassword" id="password"> <span class="error"> *<?= $pwMatch;?></span><br>
                <br><span><?= $success ?></span>
                <button type="submit" name="Register" value="Register">Register</button><br>
                <a href="index.php">Terug naar het begin</a><br>
            </form>
</fieldset>
</body>

</html>