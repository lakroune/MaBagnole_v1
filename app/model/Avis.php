<?php

namespace app\model;

use app\model\Connexion;

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
    public function setIdAvis(int $idAvis): void
    {
        if ($idAvis < 1)
            throw new \InvalidArgumentException("ID avis invalide");
        else
            $this->idAvis = $idAvis;
    }


    public function setCommentaireAvis(string $commentaireAvis): void
    {
        if (empty($commentaireAvis))
            throw new \InvalidArgumentException("Commentaire avis invalide");
        else
            $this->commentaireAvis = $commentaireAvis;
    }


    public function setNoteAvis(int $noteAvis): void
    {
        if ($noteAvis < 1 || $noteAvis > 5)
            throw new \InvalidArgumentException("Note avis invalide");
        else
            $this->noteAvis = $noteAvis;
    }


    public function setDatePublicationAvis(string $datePublicationAvis): void
    {
        if (empty($datePublicationAvis))
            throw new \InvalidArgumentException("Date publication avis invalide");
        else
            $this->datePublicationAvis = $datePublicationAvis;
    }


    public function setIdReservation(int $idReservation): void
    {
        if ($idReservation < 1)
            throw new \InvalidArgumentException("ID reservation invalide");
        else
            $this->idReservation = $idReservation;
    }


    public function setStatusAvis(int $statusAvis): void
    {
        if ($statusAvis < 1)
            throw new \InvalidArgumentException("Status avis invalide");
        else
            $this->statusAvis = $statusAvis;
    }


    public function setIdClient(int $idClient): void
    {
        if ($idClient < 1)
            throw new \InvalidArgumentException("ID client invalide");
        else
            $this->idClient = $idClient;
    }

    // tostring
    public function __toString(): string
    {
        return "idAvis : $this->idAvis , ";
    }
    // ajouter Avis
    public function ajouterAvis(): bool
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
            return false;
        }
    }


    // modifier Avis
    public function modifierAvis()
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update avis set commentaireAvis=:commentaireAvis  where idAvis=:idAvis";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":commentaireAvis", $this->commentaireAvis);
            // $stmt->bindParam(":noteAvis", $this->noteAvis);
            $stmt->bindParam(":idAvis", $this->idAvis);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    // supprimer Avis
    public function rejectReview(int $idAvis)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update avis set statusAvis=0 where idAvis=:idAvis";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idAvis", $idAvis);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }

    public function approveReview(int $idAvis)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "update avis set statusAvis=1 where idAvis=:idAvis";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idAvis", $idAvis);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }

    // getAll Avis
    public function getAllAvis()
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from avis ";
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $avis = $stmt->fetchAll(\PDO::FETCH_CLASS, Avis::class);
                return $avis;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }

    // getAll Avis by vehicule
    public function getAllAvisByVehicule(int $idVehicule): array
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from avis where statusAvis=1 and idReservation in (select idReservation from reservations where idVehicule=:idVehicule)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idVehicule", $idVehicule);
            if ($stmt->execute()) {
                $avis = $stmt->fetchAll(\PDO::FETCH_CLASS, Avis::class);
                return $avis;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return [];
        }
    }
    // check Avis
    public function checkAvis(int $idClient, int $idReservation): bool
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from avis where idClient=:idClient and idReservation=:idReservation";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            $stmt->bindParam(":idReservation", $idReservation);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0)
                    return true;
                else
                    return false;
            } else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
}
