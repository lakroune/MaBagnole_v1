<?php

class Connexion
{
    private $nomDB = "maBagnole";
    private $userDB = "root";
    private $passDB = "";
    private $hostDB = "localhost";
    public function __construct() {}
    public function connect()
    {
        try {
            $pdo = new PDO("mysql:dbname=$this->nomDB;host=$this->hostDB", $this->userDB, $this->passDB);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
          
        }
    }
}
