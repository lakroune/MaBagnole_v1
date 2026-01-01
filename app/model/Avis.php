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
    public function getIdAvis()
    {
        return $this->idAvis;
    }
    public function getCommentaireAvis()
    {
        return $this->commentaireAvis;
    }
    public function getNoteAvis()
    {
        return $this->noteAvis;
    }
    public function getDatePublicationAvis()
    {
        return $this->datePublicationAvis;
    }
    public function getIdReservation()
    {
        return $this->idReservation;
    }
    public function getStatusAvis()
    {
        return $this->statusAvis;
    }
    public function getIdClient()
    {
        return $this->idClient;
    }
    // setters
    public function setIdAvis($idAvis): bool
    {
        if (is_int($idAvis) and $idAvis > 0) {
            $this->idAvis = $idAvis;
            return true;
        }
        return false;
    }
    public function setCommentaireAvis($commentaireAvis): bool
    {
        if (strlen($commentaireAvis) > 0) {
            $this->commentaireAvis = $commentaireAvis;
            return true;
        }
        return false;
    }
    public function setNoteAvis($noteAvis): bool
    {
        if (is_int($noteAvis) and $noteAvis >= 0 and $noteAvis <= 5) {
            $this->noteAvis = $noteAvis;
            return true;
        }
        return false;
    }
    public function setDatePublicationAvis($datePublicationAvis): bool
    {
        $this->datePublicationAvis = $datePublicationAvis;
        return true;
    }
    public function setIdReservation($idReservation): bool
    {
        if (is_int($idReservation) and $idReservation > 0) {
            $this->idReservation = $idReservation;
            return true;
        }
        return false;
    }
    public function setStatusAvis($statusAvis): bool
    {
        if (is_int($statusAvis) and ($statusAvis == 0 or $statusAvis == 1)) {
            $this->statusAvis = $statusAvis;
            return true;
        }
        return false;
    }
    public function setIdClient($idClient): bool
    {
        if (is_int($idClient) and $idClient > 0) {
            $this->idClient = $idClient;
            return true;
        }
        return false;
    }
    // tostring
    public function __toString()
    {
        return "";
    }
    // ajouter Avis
    public function ajouterAvis() {}
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
}
