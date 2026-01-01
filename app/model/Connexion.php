<?php

namespace app\model;

class Connexion
{
    private string $nomDB = "MaBagnole";
    private string $userDB = "root";
    private string $passDB  = "";
    private string $hostDB = "localhost";
    private  $pdo;
    private static $instance = null;
    // constructeur private pour eviter l'instanciation de la class
    private function __construct()
    {
        try {
            $pdo = new \PDO("mysql:host=$this->hostDB;dbname=$this->nomDB;charset=utf8", $this->userDB, $this->passDB);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            $this->pdo = null;
        }
    }
    public static function connect(): Connexion
    {
        if (self::$instance == null) {
            self::$instance = new Connexion();
        }
        return self::$instance;
    }
    public function getConnexion(): ?\PDO
    {
        return $this->pdo;
    }
}
