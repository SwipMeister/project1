<?php 
    include 'db.php';


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
?>



<html>

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Welkomst <?= $_SESSION["username"] ?></title>
</head>

<body>

<fieldset>
    <div align="center">
        <h3>User panel</h3>
        <p>Ingelogd als: <span style="font-weight:bold;"><?= $_SESSION["username"] ?></span></p>
        <a class="btn btn-secondary" href="welcome_user.php">Home</a>
        <a class="btn btn-secondary" href="user_details.php">Show user details</a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
</fieldset>
</body>

</html>