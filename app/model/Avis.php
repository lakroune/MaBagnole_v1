<?php

namespace app\model;

class Avis
{
    private int $idAvis;
    private string $commentaireAvis;
    private int $noteAvis;
    private string $datePublicationAvis;
    private int $idReservation;
    private int $statusAvis;
    private int $idClient;
    // constructeur
    public function __construct() {}
    // getters
    public function getIdAvis(): int
    {
        return $this->idAvis;
    }
    public function getCommentaireAvis(): string
    {
        return $this->commentaireAvis;
    }
    public function getNoteAvis(): int
    {
        return $this->noteAvis;
    }
    public function getDatePublicationAvis(): string
    {
        return $this->datePublicationAvis;
    }
    public function getIdReservation(): int
    {
        return $this->idReservation;
    }
    public function getStatusAvis(): int
    {
        return $this->statusAvis;
    }
    public function getIdClient(): int
    {
        return $this->idClient;
    }
    // setters 
    public function setIdAvis($idAvis): void
    {
        if ($idAvis < 1)
            throw new \InvalidArgumentException("ID avis invalide");
        else
            $this->idAvis = $idAvis;
    }


    public function setCommentaireAvis($commentaireAvis): void
    {
        if (empty($commentaireAvis))
            throw new \InvalidArgumentException("Commentaire avis invalide");
        else
            $this->commentaireAvis = $commentaireAvis;
    }


    public function setNoteAvis($noteAvis): void
    {
        if ($noteAvis < 1)
            throw new \InvalidArgumentException("Note avis invalide");
        else
            $this->noteAvis = $noteAvis;
    }


    public function setDatePublicationAvis($datePublicationAvis): void
    {
        if (empty($datePublicationAvis))
            throw new \InvalidArgumentException("Date publication avis invalide");
        else
            $this->datePublicationAvis = $datePublicationAvis;
    }


    public function setIdReservation($idReservation): void
    {
        if ($idReservation < 1)
            throw new \InvalidArgumentException("ID reservation invalide");
        else
            $this->idReservation = $idReservation;
    }


    public function setStatusAvis($statusAvis): void
    {
        if ($statusAvis < 1)
            throw new \InvalidArgumentException("Status avis invalide");
        else
            $this->statusAvis = $statusAvis;
    }


    public function setIdClient($idClient): void
    {
        if ($idClient < 1)
            throw new \InvalidArgumentException("ID client invalide");
        else
            $this->idClient = $idClient;
    }

    // tostring
    public function __toString()
    {
        return "";
    }
    // ajouter Avis
    public function ajouterAvis()
    {
        try {

            $db = Connexion::connect()->getConnexion();
            $sql = "insert into avis(idReservation, commentaireAvis, noteAvis,idClient) values (:idReservation, :commentaireAvis, :noteAvis ,:idClient)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idReservation", $this->idReservation);
            $stmt->bindParam(":commentaireAvis", $this->commentaireAvis);
            $stmt->bindParam(":noteAvis", $this->noteAvis);
            $stmt->bindParam(":idClient", $this->idClient);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }


    // modifier Avis
    public function modifierAvis() {}
    // supprimer Avis
    public function supprimerAvis() {}
    // confirmer Avis
    public function getAvis(int $idAvis) {}
    // getAll Avis
    public function getAllAvis() {}
    // conter Avis by vehicule
    public function conterAvisByVehicule(int $idVehicule) {}
    // getAll Avis by vehicule
    public function getAllAvisByVehicule(int $idVehicule)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from avis where idReservation in (select idReservation from reservations where idVehicule=:idVehicule)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                $avis = $stmt->fetchAll(\PDO::FETCH_OBJ);
                return $avis;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
    // check Avis
    public function checkAvis(int $idClient, int $idReservation)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from avis where idClient=:idClient and idReservation=:idReservation";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            $stmt->bindParam(":idReservation", $idReservation);
            if ($stmt->execute()) {
                $avis = $stmt->fetch(\PDO::FETCH_OBJ);
                if ($avis)
                    return true;
                else
                    return false;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return null;
        }
    }
}
