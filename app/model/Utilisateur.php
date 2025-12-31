<?php
class Utilisateur
{
    protected int $idUtilisateur;
    protected string $nomUtilisateur;
    protected string $prenomUtilisateur;
    protected string $email;
    protected string $paword;
    protected string $role;
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
    public function seconnecter() {
        
    }
    //sdeconnecter
    public function sedeconnecter() {}

}
