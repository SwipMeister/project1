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

    $db = new Database('localhost', 'project1', 'root', '',  'utf8');


    // returned een associative array
    $result_user_set = $db->get_user_data($_SESSION['username'])[0];

    // resultaat splitten in key en value
    $columns = array_keys($result_user_set);
    $rows = array_values($result_user_set);

?>



<html>

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
    <title>View users</title>
</head>

<body>


    <div align="center">
        <h3>User panel</h3>
        <p>Ingelogd als: <span style="font-weight:bold;"><?= $_SESSION["username"] ?></span></p>
        <a class="btn btn-secondary" href="welcome_user.php">Home</a> |
        <a class="btn btn-secondary" href="user_details.php">Show user details</a> |
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>




<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>View user details</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php // loop kolommen in database en zet ze als table haed
                            foreach ($columns as $column) {
                                echo "<th> $column </th>";
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php // loop rows in database en zet deze in td maar alleen WHERE username = :username
                            foreach ($rows as $row) {
                                echo "<td> $row </td>";
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>   
</body>

</html>