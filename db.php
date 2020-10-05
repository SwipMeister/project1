<?php

class DB {

    
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $db;

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
            echo "Database connection succesfully established <br>" ;

        } catch (PDOException $e) {

            echo $e->getMessage();
            exit("An error occured");
        }

    }

    public function insertAccount($email, $password){

        // try -> catch 
        // begin transaction
        // committen naar DB

        try {

            //begin transaction
            $this->db->beginTransaction();
            echo "1. transaction begun";

            $sql1 = "INSERT INTO account(id, email, password) VALUES (:id, :email, :password)"; // replacement fields
            echo '<br> 2. sql statement voor tabel account: '. $sql1;
            $stmt = $this->db->prepare($sql1); 
            echo '<br> 3. ';
            print_r($stmt);
            // execute de stmt en hash het password
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['id' => NULL,'email' => $email,'password' => $hashPassword]);
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
    
    

    public function insertPersoon($username, $voornaam, $tussenvoegsel, $achternaam, $email, $lastID){
        
        // try -> catch 
        // begin transaction
        // committen naar DB
        try {
            
            //begin transaction
            $this->db->beginTransaction();
            echo "1. transaction begun";
            // Statement voor tabel persoon na inserten van tabel account
            $sql2 = "INSERT INTO persoon(id, account_id, username, voornaam, tussenvoegsel, achternaam) VALUES (:id, :account_id, :username, :voornaam, :tussenvoegsel, :achternaam)"; // replacement fields
            echo '<br> 2. sql statement voor tabel persoon: '. $sql2;
            $stmt2 = $this->db->prepare($sql2); 
            echo '<br> 3. ';
            print_r($stmt2);
            
            $stmt2->execute(['id' => NULL,'account_id' => $lastID,'username' => $username, 'voornaam' => $voornaam, 'tussenvoegsel' => $tussenvoegsel, 'achternaam' => $achternaam]);
            
            $this->db->commit();

            
        } catch (Exception $a) {
            $this->db->rollback();
            throw $a;
            echo "Persoon Rollback executed";
        }
    
    }

}
//
// executen
// lastInsertId() om id op te halen voor insert into persoon
// password hashen DONE