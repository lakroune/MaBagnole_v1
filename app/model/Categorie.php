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
    public function getIdCategorie(): int
    {
        return $this->idCategorie;
    }

    public function getTitreCategorie(): string
    {
        return $this->titreCategorie;
    }

    public function getDescriptionCategorie(): string
    {
        return $this->descriptionCategorie;
    }


    //setters
    public function setIdCategorie($idCategorie): bool
    {
        if ($idCategorie > 0) {
            $this->idCategorie = $idCategorie;
            return true;
        }
        return false;
    }

    public function setTitreCategorie(string $titreCategorie): bool
    {
        if (strlen($titreCategorie) > 0) {
            $this->titreCategorie = $titreCategorie;
            return true;
        }
        return false;
    }

    public function setDescriptionCategorie(string $descriptionCategorie): bool
    {
        if (strlen($descriptionCategorie) > 0) {
            $this->descriptionCategorie = $descriptionCategorie;
            return true;
        }
        return false;
    }


    public function __toString(): string
    {
        return "Categorie [idCategorie=$this->idCategorie, titreCategorie=$this->titreCategorie, descriptionCategorie=$this->descriptionCategorie]";
    }

    public function ajouterCategorie(): bool
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
    public function modifierCategorie(): bool
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

    public function supprimerCategorie(int $idCategorie): bool
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
    public function getCategoriebyId(int $idCategorie)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from categories where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idCategorie", $idCategorie);
            if ($stmt->execute()) {
                $categorie = $stmt->fetchObject(Categorie::class);
                return $categorie;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }

    public static function getAllCategories(): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from categories";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $categories = $stmt->fetchAll(\PDO::FETCH_CLASS, Categorie::class);
                return $categories;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    public static function counterCategorie(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as nombre from categories";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return (int)$result['nombre'];
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
}
