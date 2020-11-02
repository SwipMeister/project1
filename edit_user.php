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
    
    // als account_id en persoon_id geset zijn --> function dropUser
    if (isset($_GET['account_id']) && isset($_GET['persoon_id'])) {
        
        $account_id = $_GET['account_id'];
        $persoon_id = $_GET['persoon_id'];

        $db->dropUser($account_id, $persoon_id);
        header("refresh:1;url=edit_user.php");

    }

    // returned een associative array
    $result_user_set = $db->get_user_data(NULL);

    
    $columns = array_keys($result_user_set[0]); // [0] = fetched assoc array

    

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
        <h3>Admin panel</h3>
        <p>Ingelogd als: <span style="font-weight:bold;"><?= $_SESSION["username"] ?></span></p>
        <a class="btn btn-secondary" href="welcome_admin.php">Home</a> |
        <a class="btn btn-secondary" href="adduser_seperate.php">Add/Edit user</a> |
        <a class="btn btn-secondary" href="edit_user.php">View, edit or delete user</a> |
        <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>




<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>View or edit user details</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <?php // loop kolommen in database en zet ze als table haed ?>
                           <?php foreach ($columns as $column) { ?>
                                
                            <th> <?php echo $column ?>  </th>
                            <?php } ?>
                            <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php // loop de resultset en zet ze als row met id zodat er een nieuwe aangemaakt wordt ?>
                          <?php  foreach ($result_user_set as $rows => $row) { ?>
                            <?php   $row_id = $row['id']; ?>
                          
                    <tr>
                    <?php // loop de rows  ?>
                    <?php  foreach ($row as $user_data) { ?>


                                <td> <?php echo $user_data ?></td>
                                <?php  }?>

                                <td><a href="add_user.php?account_id=<?php echo $row_id; ?>&persoon_id=<?php echo $row['persoon_id']?>" class="btn btn-primary">Edit</a></td>
                                <td><a href="edit_user.php?account_id=<?php echo $row_id; ?>&persoon_id=<?php echo $row['persoon_id']?>" class="btn btn-danger">Delete</a></td>
                                <!-- TODO: dropUser function, addUser function, editUser function -->
                        
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   
</body>

</html>