<?php

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
    public function __get($aturibut) {}
    // setters
    public function __set($aturibut, $value) {}
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
