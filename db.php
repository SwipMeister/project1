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

    // public function user_role_check() {
        
    // }

    // public function signup()
    
    //

    public function insertAccount($username, $email, $password){

        // try -> catch 
        // begin transaction
        // committen naar DB

        try {

            //begin transaction
            $this->db->beginTransaction();
            echo "1. transaction begun";

            $sql1 = "INSERT INTO account(id, username, email, password) VALUES (:id, :username, :email, :password)"; // replacement fields
            echo '<br> 2. sql statement voor tabel account: '. $sql1;
            $stmt = $this->db->prepare($sql1); 
            echo '<br> 3. ';
            print_r($stmt);
            // execute de stmt en hash het password
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['id' => NULL, 'username' => $username, 'email' => $email,'password' => $hashPassword]);
            echo '<br> password: ' . $hashPassword . '<br>';

            // $test1 = $this->db->lastInsertId();
            // echo '<br> last inserted ID = ';
            // print_r($test1);
            $lastID = $this->db->lastInsertId();
            echo '<br>' . $lastID;
            
            $this->db->commit();
            // lastInsertId() -> meegeven aan je insert van je persoon
            return $lastID;

            
        } catch (Exception $a) {
            $this->db->rollback();
            throw $a;
            echo "Account Rollback executed";
        }
    }
    
    

    public function insertPersoon($voornaam, $tussenvoegsel, $achternaam, $email, $lastID){
        
        // try -> catch 
        // begin transaction
        // committen naar DB
        try {
            
            //begin transaction
            $this->db->beginTransaction();
            echo "1. transaction begun";
            // Statement voor tabel persoon na inserten van tabel account
            $sql2 = "INSERT INTO persoon(id, account_id, voornaam, tussenvoegsel, achternaam) VALUES (:id, :account_id, :voornaam, :tussenvoegsel, :achternaam)"; // replacement fields
            echo '<br> 2. sql statement voor tabel persoon: '. $sql2;
            $stmt2 = $this->db->prepare($sql2); 
            echo '<br> 3. ';
            print_r($stmt2);
            
            $stmt2->execute(['id' => NULL,'account_id' => $lastID, 'voornaam' => $voornaam, 'tussenvoegsel' => $tussenvoegsel, 'achternaam' => $achternaam]);
            
            $this->db->commit();

            
        } catch (Exception $a) {
            $this->db->rollback();
            throw $a;
            echo "Persoon Rollback executed";
        }
    
    }

    public function login($username, $password) {
        
        // id, type_id, password opvragen van :username, dit is de username die de user invult
        $sql = "SELECT id, password 
                FROM account
                WHERE username = :username";

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
                print_r( $result);
                echo "<br>";
    
                // gehashte password in var zetten om te checken met password_verify
                $hashed_pw = $result['password'];

                // var_dump password_verify om te kijken of t ingevulde wachtwoord overeenkomt met de hash
                var_dump(password_verify($password, $hashed_pw));
                echo "<br>";

                // check if user exists and if passwords match
                if ($username && password_verify($password, $hashed_pw)) {
                    session_start();
    
                    // userdate opslaan in session variables
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['username'] = $username;
                    // $_SESSION['usertype'] = $result['type_id']; add to $sql when usertype is fixed
                    $_SESSION['loggedin'] = true;
                    echo 'session started';
                    echo 'Welkom' . $username;
    
                }else {
                    // als de username en password niet overeenkomen print:
                    return 'Username en/of password zijn verkeerd, probeer opnieuw';
                }
            

        }else{
            // no matching user found in db. Make sure not to tell the user.
            return "Inloggen mislukt, probeer opnieuw.";
        }

    }

}
//
// executen
// lastInsertId() om id op te halen voor insert into persoon
// password hashen DONE

// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//     echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
// } else {
//     echo "Please log in first to see this page.";
// }