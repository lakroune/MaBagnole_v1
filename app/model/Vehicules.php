<?php

namespace app\model;

class Vehicules
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
    public function __toString() {}
    //ajouter Vehicule
    public function ajouterVehicule() {}
    //modifier Vehicule
    public function modifierVehicule() {}
    //supprimer Vehicule
    public function supprimerVehicule() {}
    //getVehicule
    public function getVehicule() {}
    //getAllVehicules
    public function getAllVehicules() {}
    //getVehiculesByCategorie
    public function getVehiculesByCategorie() {}
    //getVehiculesByMarque
    public function getVehiculesByMarque() {}
}
