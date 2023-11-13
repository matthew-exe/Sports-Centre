<?php

// database handler

// $host = "localhost";
// $dbname = "myfirstdatabase";
// $dbusername = "root";
// $dbpassword = "";

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }

class dbh {
    private $host;
    private $dbname;
    private $dbusername;
    private $dbpassword;
    private $charset;

    public function connect() {
        $this->host = "localhost";
        $this->dbname = "myfirstdatabase";
        $this->dbusername = "root";
        $this->dbpassword = "";
        $this->charset = "utf8mb4";

        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
            $pdo = new PDO($dsn, $this->dbusername, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}