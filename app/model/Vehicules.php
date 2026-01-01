<?php

namespace app\model;

class Vehicule
{
    private int $idVehicule;
    private string $marqueVehicule;
    private string $modeleVehicule;
    private string $anneeVehicule;
    private string $imageVehicule;
    private string $typeBoiteVehicule;
    private string $typeCarburantVehicule;
    private string $couleurVehicule;
    private string $prixVehicule;
    private int $idCategorie;

    //constructeur par default
    public function __construct() {}
    //getters
    public function __get($attribute)
    {
        return $this->$attribute;
    }
    //setters
    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    //tostring
    public function __toString()
    {
        return "Vehicule [idVehicule=$this->idVehicule, marqueVehicule=$this->marqueVehicule, modeleVehicule=$this->modeleVehicule, anneeVehicule=$this->anneeVehicule, imageVehicule=$this->imageVehicule, typeBoiteVehicule=$this->typeBoiteVehicule, typeCarburantVehicule=$this->typeCarburantVehicule, couleurVehicule=$this->couleurVehicule, prixVehicule=$this->prixVehicule, idCategorie=$this->idCategorie]";
    }
    //ajouter Vehicule
    public function ajouterVehicule()
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "insert into vehicules (marqueVehicule, modeleVehicule, anneeVehicule, imageVehicule, typeBoiteVehicule, typeCarburantVehicule, couleurVehicule, prixVehicule, idCategorie) values (:marqueVehicule, :modeleVehicule, :anneeVehicule, :imageVehicule, :typeBoiteVehicule, :typeCarburantVehicule, :couleurVehicule, :prixVehicule, :idCategorie)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":marqueVehicule", $this->marqueVehicule);
            $stmt->bindParam(":modeleVehicule", $this->modeleVehicule);
            $stmt->bindParam(":anneeVehicule", $this->anneeVehicule);
            $stmt->bindParam(":imageVehicule", $this->imageVehicule);
            $stmt->bindParam(":typeBoiteVehicule", $this->typeBoiteVehicule);
            $stmt->bindParam(":typeCarburantVehicule", $this->typeCarburantVehicule);
            $stmt->bindParam(":couleurVehicule", $this->couleurVehicule);
            $stmt->bindParam(":prixVehicule", $this->prixVehicule);
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
    //modifier Vehicule
    public function modifierVehicule(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update vehicules set marqueVehicule=:marqueVehicule, modeleVehicule=:modeleVehicule, anneeVehicule=:anneeVehicule, imageVehicule=:imageVehicule, typeBoiteVehicule=:typeBoiteVehicule, typeCarburantVehicule=:typeCarburantVehicule, couleurVehicule=:couleurVehicule, prixVehicule=:prixVehicule, idCategorie=:idCategorie where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":marqueVehicule", $this->marqueVehicule);
            $stmt->bindParam(":modeleVehicule", $this->modeleVehicule);
            $stmt->bindParam(":anneeVehicule", $this->anneeVehicule);
            $stmt->bindParam(":imageVehicule", $this->imageVehicule);
            $stmt->bindParam(":typeBoiteVehicule", $this->typeBoiteVehicule);
            $stmt->bindParam(":typeCarburantVehicule", $this->typeCarburantVehicule);
            $stmt->bindParam(":couleurVehicule", $this->couleurVehicule);
            $stmt->bindParam(":prixVehicule", $this->prixVehicule);
            $stmt->bindParam(":idCategorie", $this->idCategorie);
            $stmt->bindParam(":idVehicule", $this->idVehicule);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //supprimer Vehicule 
    public function supprimerVehicule(int $idVehicule): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "delete from vehicules where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    //get vehicule by id
    public function getVehiculeById(int $idVehicule): ?Vehicule
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules where idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                $vehicule = $stmt->fetch(\PDO::FETCH_OBJ);
                return $vehicule;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
    //return all vehicules
    public function getAllVehicules(): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $vehicules = $stmt->fetchAll(\PDO::FETCH_OBJ);
                return $vehicules;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    //getVehiculesByCategorie
    public function getVehiculesByCategorie(int $idCategorie): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from vehicules where idCategorie=:idCategorie";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idCategorie", $idCategorie);
            if ($stmt->execute()) {
                $vehicules = $stmt->fetchAll(\PDO::FETCH_OBJ);
                return $vehicules;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    // counter vehicules
    public static function counterVehicules(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from vehicules";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            return (int)$result->total;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
    //getVehiculesByMarque
    public function getVehiculesByMarque() {}
}
