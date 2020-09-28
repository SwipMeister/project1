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

            $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
            $this->db = new PDO($dsn, $this->username, $this->password);
            echo "Database connection succesfully established";
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit("An error occured");
        }

    }

    public function insertAccount($email, $password){

        //try -> catch
        // begin transaction
        // committen naar DB

        try {

            //begin transaction
            echo "Hallo dit is een test bericht";
            $sql1 = "INSERT INTO account('id', 'email', 'password') VALUES(?, :email, :password)";
            echo 'sql statement: '. $sql1;
            $stmt = $this->db->prepare($sql1); 
            print_r($stmt);

            // password hashen

            $stmtExecute = $stmt->execute([NULL, 'email'=>$email, 'password'=>$password]);

            // lastInsertId() -> meegeven aan je insert van je persoon
            
        } catch () {
            //PDO rollback
        }


    }

}
