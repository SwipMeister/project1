<?php

class Database {

    
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $db;

    const ADMIN = 1;
    const USER = 2;

    public function __construct($host, $db_name, $username, $password, $charset){
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;

        try {
            // data source name
            $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
            $this->db = new PDO($dsn, $this->username, $this->password);
            // echo "Database connection succesfully established <br>" ;

        } catch (PDOException $e) {

            // die met error message
            die("An error occured" . $e->getMessage());
        }

    }


    private function new_account_check($username){
        
        // select alles in tabel account van ingevulde username door user
        $stmt = $this->db->prepare('SELECT * FROM account WHERE username=:username');
        $stmt->execute(['username'=>$username]);
        // stop resultaat van fetch() in een variabele
        $result = $stmt->fetch();

        if(is_array($result) && count($result) > 0){
            // return false als de user bestaat
            return false;
        }else{
            // return true als de user niet bestaat
            return true;

        }

    }

    public function get_account_details($id) {

        $statement = $this->db->prepare("SELECT * FROM account WHERE id=:id");
        $statement->execute(['id'=>$id]);
        $account = $statement->fetch(PDO::FETCH_ASSOC);

        return $account;
        
    }
    public function get_persoon_details($id) {

        $statement = $this->db->prepare("SELECT * FROM persoon WHERE id=:id");
        $statement->execute(['id'=>$id]);
        $persoon = $statement->fetch(PDO::FETCH_ASSOC);
        return $persoon;

    }

    public function user_admin_check($username) {

        $sql = "SELECT type FROM account WHERE username = :username";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username'=>$username]);

        // stop resultaat van fetch() in een variabele
        $result = $stmt->fetch();
        
        if($result['type'] == self::ADMIN){
            // user is admin
            return true;
        }else{
            // user is not admin
            return false;
        }

    }

    public function alterAccount($id, $username, $email, $type, $password){
        // geeft format mee aan var
        $updated_at = date('Y-m-d H:i:s');

        // als id NULL is (zoals t gesupplied wordt)
        if (is_null($id)) {

            // secure password
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            //(id, username, email, type, password)
            $sql = "INSERT INTO account VALUES (NULL, :username, :email, :type, :password, :created, :updated)"; // replacement fields
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute(['username' => $username, 'email' => $email, 'type' => $type, 'password' => $hashPassword, 'created' => date('Y-m-d H:i:s'), 'updated' => $updated_at]);
            
            $account_id = $this->db->lastInsertId();
            return $account_id;
        }else {
           
            $sql = "UPDATE account SET username = :username, email = :email, type = :type, updated_at = :updated WHERE id = :id";
       
            $statement = $this->db->prepare($sql);

            $statement->execute(['username'=>$username, 'email'=> $email, 'type'=>$type, 'updated'=> $updated_at,'id'=>$id]);

            $account_id = $this->db->lastInsertId();
            return $account_id;
        }

    }

    public function alterPersoon($id, $account_id, $voornaam, $tussenvoegsel, $achternaam){
        // geeft format mee aan var
        $updated_at = date('Y-m-d H:i:s');

        // als id NULL is (zoals t gesupplied wordt)
        if (is_null($id)) {

            // secure password
            //(id, type username, email, password)
            $sql = "INSERT INTO persoon VALUES (NULL, :account_id, :voornaam, :tussenvoegsel, :achternaam, :created, :updated)"; // replacement fields
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute(['account_id' => $account_id, 'voornaam' => $voornaam, 'tussenvoegsel' => $tussenvoegsel,'achternaam' => $achternaam, 'created' => date('Y-m-d H:i:s'), 'updated' => $updated_at]);
            
            $persoon_id = $this->db->lastInsertId();
            return $persoon_id;
        }else {
           
            $sql = "UPDATE persoon SET voornaam = :voornaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam, updated_at = :updated WHERE id = :id";
       
            $statement = $this->db->prepare($sql);

            $statement->execute(['id'=>$id, 'voornaam'=>$voornaam, 'tussenvoegsel'=> $tussenvoegsel, 'achternaam'=> $achternaam, 'updated'=> $updated_at]);

            $persoon_id = $this->db->lastInsertId();
            return $persoon_id;
        }
    
    }

    public function alterUser($account_details, $persoon_details) {

        if(is_array($account_details) && is_array($persoon_details)){
            echo  'meh';
            try{

                // start transactie
                $this->db->beginTransaction();
                // set variables voor inhoud $account_details array
                $id = $account_details['account_id'];
                $username = $account_details['username']; 
                $email = $account_details['email']; 
                $type = $account_details['type']; 

                $account_id = $this->alterAccount($id, $username, $email, $type, NULL);
                // set variables
                $id = $persoon_details['persoon_id'];
                $voornaam = $persoon_details['voornaam'];
                $tussenvoegsel = $persoon_details['tussenvoegsel'];
                $achternaam = $persoon_details['achternaam'];
                $this->alterPersoon($id, $account_id, $voornaam, $tussenvoegsel, $achternaam);

                // commit database change
                $this->db->commit();
                header('location: edit_user.php');
                return 'User data succesfully updated';
            }catch(Exception $e){
                $this->db->rollback();
                echo 'Error occurred: '.$e->getMessage();
            }
            
        }else {

            // return string error msg
            return 'account en persoon informatie zijn geen array.';
        }

    }

    public function signup($username, $voornaam, $tussenvoegsel, $achternaam, $email, $type, $password){
        try {
            //start transactie
            $this->db->beginTransaction();

            // check of het een bestaande gebruiker is met functie new_account_check
            // NIET false dus TRUE betekent user bestaat
            if (!$this->new_account_check($username)) {
                return "Username al in gebruik, kies een andere username.";
            }

            // database insertion
            $account_id = $this->alterAccount(NULL, $username, $email, $type, $password);
            $this->alterPersoon(NULL, $account_id, $voornaam, $tussenvoegsel, $achternaam);

            // commit database change
            $this->db->commit();

            if(isset($_SESSION) && $_SESSION['type'] == self::ADMIN){
                return "Nieuwe gebruiker toegevoegd.";
            }
            echo '<h3 align="center">Registratie voltooid. U wordt doorverwezen naar de login</h3>';
            header("refresh:3;url=index.php");
            // exit makes sure that further code isn't executed.
            exit;
            
            


        } catch (Exception $e) {
            // rollback database changes in case of an error to maintain data integrity.
            $this->db->rollback();
            echo "Signup failed: " . $e->getMessage();
        }


    }

    public function login($username, $password) {
        
        // id, type, password opvragen van :username, dit is de username die de user invult
        $sql = "SELECT id, password FROM account WHERE username = :username";

        // query preparen en executen
        $stmt = $this->db->prepare($sql);

        // execute 
        $stmt->execute(['username'=>$username]);
        
        // Resultaat van fetch() in var stoppen -> array
        $result = $stmt->fetch();
        // var_dump($result);

        // check if $result is array
        if (is_array($result) && count($result) > 0) {

            // double check of $result een arrau heeft
                // print_r( $result);
                // echo "<br>";
    
                // gehashte password in var zetten om te checken met password_verify
                $hashed_pw = $result['password'];

                // var_dump password_verify om te kijken of t ingevulde wachtwoord overeenkomt met de hash
                // var_dump(password_verify($password, $hashed_pw));
                // echo "<br>";

                // check if user exists and if passwords match
                if ($username && password_verify($password, $hashed_pw)) {
                    session_start();
    
                    // userdate opslaan in session variables
                    

                    $_SESSION['id'] = $result['id'];
                    $_SESSION['username'] = $username;
                    // $_SESSION['usertype'] = $result['type']; add to $sql when usertype is fixed
                    $_SESSION['loggedin'] = true;

                    // 0 = DISABLED, 1 = NONE, 2 = ACTIVE
                    // print_r(session_status());

                    header("refresh:3;url=welcome_admin.php"); 

                    // returnt true of false (admin of user)
                    if ($this->user_admin_check($username)) {
                        echo 'Welkom ' . $username . '. U wordt doorverwezen naar de welkomstpagina';
                        header("refresh:3;url=welcome_admin.php"); 
                        exit(); // code hieronder mag niet executen 

                        
                    }else{
                        echo 'Welkom ' . $username . '. U wordt doorverwezen naar de welkomstpagina';
                        header("refresh:3;url=welcome_user.php"); 
                        exit(); // code hieronder mag niet executen 

                    }

                }else {
                    // als de username en password niet overeenkomen print:
                    return 'Username en/of password zijn verkeerd, probeer opnieuw';
                }
            

        }else{
            // no matching user found in db. Make sure not to tell the user.
            return "Inloggen mislukt, probeer opnieuw.";
        }

    }

    public function dropUser($account_id, $persoon_id){
        // echo $account_id, $persoon_id;

        // standard try catch
        try{
            $this->db->beginTransaction();
            // first drop from persoon (conflict als account eerst verwijderd wordt)
            $stmt = $this->db->prepare("DELETE FROM persoon WHERE id=:id");
            $stmt->execute(['id'=>$persoon_id]);
            // dan van account droppen
            $stmt = $this->db->prepare("DELETE FROM account WHERE id=:id");
            $stmt->execute(['id'=>$account_id]);

            $this->db->commit();

        }catch(Exception $e){
            $this->db->rollback();
            echo 'Error: '.$e->getMessage();
        }
    }

    // user details opvragen, als user dit doet zal zijn session username meegegeven worden en alleen zijn data showen, zo niet zal alle data geshowt worden
    public function get_user_data($username){
        $sql = "SELECT a.id, p.id as persoon_id, u.type, p.voornaam, p.tussenvoegsel, p.tussenvoegsel, p.achternaam, a.username,  a.email 
        FROM persoon as p 
        LEFT JOIN account as a
        ON p.account_id = a.id
        LEFT JOIN usertype as u
        ON a.type = u.id       
    ";

        if($username !== NULL){
            // pas als deze check is uitgevoerd WHERE username = username van ingelogde aan query toevoegen
            $sql .= 'WHERE a.username = :username';

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['username'=>$username]);
            // fetch associative array 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            // fetch associative array 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }

    

}
