<?php

namespace app\model;

use app\model\Connexion;

class Categorie
{
    private int $idCategorie;
    private string $titreCategorie;
    private string $descriptionCategorie;
    // constructeur
    public function __construct() {}
    //getters
    public function __get($aturibut)
    {
        return $this->$aturibut;
    }
    //setters
    public function __set($aturibut, $value)
    {
        $this->$aturibut = $value;
    }
    public function __toString()
    {
        return "Categorie [idCategorie=$this->idCategorie, titreCategorie=$this->titreCategorie, descriptionCategorie=$this->descriptionCategorie]";
    }

    public function getCatigorie(int $idCategorie) {}

    public static function getAllCategories() {}
    public static function cconterCategorie(): int
    {
        return 0;
    }
    public function AjouterCategorie(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "insert into categories (titreCategorie,descriptionCategorie) values (:titreCategorie,:descriptionCategorie)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":titreCategorie", $this->titreCategorie);
            $stmt->bindParam(":descriptionCategorie", $this->descriptionCategorie);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function ModifierCategorie(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update categories set titreCategorie=:titreCategorie, descriptionCategorie=:descriptionCategorie where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":titreCategorie", $this->titreCategorie);
            $stmt->bindParam(":descriptionCategorie", $this->descriptionCategorie);
            $stmt->bindParam(":idCategorie", $this->idCategorie);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function SupprimerCategorie(int $idCategorie): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "delete from categories where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idCategorie", $idCategorie);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function RechercherCategorie(int $idCategorie): ?Categorie
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from categories where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idCategorie", $idCategorie);
            $stmt->execute();
            $categorie = $stmt->fetch(\PDO::FETCH_OBJ);
            return $categorie;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
    public function AfficherCategorie(int $idCategorie) {}
}
