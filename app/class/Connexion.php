<?php

class Connexion
{
    private string $nomDB;
    private string $userDB;
    private string $passDB;
    private string $hostDB;
    // constructeur private pour eviter l'instanciation de la class
    private function __construct()
    {
        $this->nomDB = "MaBagnole";
        $this->userDB = "root";
        $this->passDB = "";
        $this->hostDB = "localhost";
    }
    public static function connect()
    {
        $connexion = new Connexion();
        try {
            $pdo = new PDO("mysql:dbname=$connexion->nomDB;host=$connexion->hostDB", $connexion->userDB, $connexion->passDB);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
}
