<?php

class dbh {
    private $host;
    private $dbname;
    private $dbusername;
    private $dbpassword;
    private $charset;

    public function connect() {
		// Set these to fit your hosting enviroment
        $this->host = "";
        $this->dbname = "";
        $this->dbusername = "";
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