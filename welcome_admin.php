<?php 
    include 'db.php';


    // TODO:session start 
    session_start();

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        $_SESSION['loggedin'] = true;
        $username = $_SESSION['username'];
        
    }else {
        header("refresh:3;url=index.php");
        exit;
    }

?>



<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">      
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Welkom <?= $username ?></title>
</head>

<body>

<fieldset>
    <div align="center">
        <h3>Admin panel</h3>
        <p>Ingelogd als: <span style="font-weight:bold;"><?= $username ?></span></p>
        <a class="btn btn-secondary" href="welcome_admin.php">Home</a>
        <a class="btn btn-secondary" href="edit_user.php">View, edit or delete user</a> |
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
</fieldset>
</body>

</html>