<?php
class Utilisateur
{
    public int $idUtilisateur;
    public string $nomUtilisateur;
    public string $prenomUtilisateur;
    public string $email;
    public string $paword;
    public string $role;
    // constructeur
    public function __construct() {}
    // getters
    public function __get($aturibut)
    {
        return $this->$aturibut;
    }
    // setters
    public function __set($aturibut, $value)
    {
        $this->$aturibut = $value;
    }
    //toString
    public function __toString()
    {
        return "idUtilisateur=$this->idUtilisateur, nomUtilisateur=$this->nomUtilisateur, prenomUtilisateur=$this->prenomUtilisateur, email=$this->email, role=$this->role";
    }
    //seconnecter
    public function seconnecter() {}
    //sdeconnecter
    public function sdeconnecter() {}
    
}
