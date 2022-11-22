<?php
session_start();

/* Database Connection */
class DbConnection {  
 public $dbHost = "localhost";
 public $dbUser = "root";
 public $dbPassword = "";
 public $dbName = "snackwise";
 public $conn;
 
  function connect() {  
      try {
        $conn = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, $this->dbUser, $this->dbPassword);
        return $conn;  
      } catch(PDOException $e) {
        echo "Datanase Connection Failed: " . $e->getMessage();
      }
  }  
}  
?>