<?php

namespace app\model;

class Favori
{
    private int $idClient;
    private int $idVehicule;
    // constructeur
    public function __construct() {}
    // getters
    public function getIdClient()
    {
        return $this->idClient;
    }

    public function getIdVehicule()
    {
        return $this->idVehicule;
    }


    // setters
    public function setIdClient($idClient)
    {
        if ($idClient > 0) {
            $this->idClient = $idClient;
            return true;
        }
        return false;
    }


    public function setIdVehicule($idVehicule)
    {
        if ($idVehicule > 0) {
            $this->idVehicule = $idVehicule;
            return true;
        }
        return false;
    }
    // tostring
    public function __toString()
    {
        return "idClient: " . $this->idClient . ", idVehicule: " . $this->idVehicule;
    }
    // ajouter Favori
    public function ajouterFavori()
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
    public function annulerFavori()
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
    public function getFavori(int $idClient, int $idVehicule)
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
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
}
