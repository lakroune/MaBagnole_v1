<?php
namespace app\model;

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
    public function AjouterCategorie() {}
    public function ModifierCategorie() {}
    public function SupprimerCategorie() {}
    public function RechercherCategorie(int $idCategorie) {}
    public function AfficherCategorie(int $idCategorie) {}
}
