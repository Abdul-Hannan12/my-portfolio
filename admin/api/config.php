<?php

class database
{

  private $dsn = "mysql:host=localhost; dbname=abdul_hannan";
  private $dbuser = "root";
  private $dbpass = "";

  public $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);

    } catch (PDOException $e) {
      echo "Error : " . $e->getmessage();
    }
    return $this->conn; 
  }

}
