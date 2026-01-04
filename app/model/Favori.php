<?php

namespace app\model;

use app\model\Connexion;

class Favori
{
    private int $idClient;
    private int $idVehicule;
    // constructeur
    public function __construct() {}
    // getters
    public function getIdClient(): int
    {
        return $this->idClient;
    }

    public function getIdVehicule(): int
    {
        return $this->idVehicule;
    }


    // setters
    public function setIdClient($idClient): void
    {
        if ($idClient < 1) {
            throw new \InvalidArgumentException("ID client invalide");
        } else {
            $this->idClient = $idClient;

        }
    }

    public function setIdVehicule($idVehicule): void
    {
        if ($idVehicule < 1) {
            throw new \InvalidArgumentException("ID vehicule invalide");
        } else {
            $this->idVehicule = $idVehicule;
        }
    }

    // tostring
    public function __toString()
    {
        return "idClient: " . $this->idClient . ", idVehicule: " . $this->idVehicule;
    }
    // ajouter Favori
    public function ajouterFavori(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "insert into favoris (idClient, idVehicule) values (:idClient, :idVehicule)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $this->idClient);
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
    // annuler Favori
    public function annulerFavori(): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "delete from favoris where idClient=:idClient and idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $this->idClient);
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

    // si deja Favori
    public function isFavori(int $idClient, int $idVehicule): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) from favoris where idClient=:idClient and idVehicule=:idVehicule";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                if ($stmt->fetchColumn() > 0)
                    return true;
                else
                    return false;
            }
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
}
