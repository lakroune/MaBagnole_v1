<?php

class Client extends Utilisateur
{
    private int $statusClient;
    private string $telephone;
    private string $ville;
    private DateTime $createdAt;
    // constructeur Client
    public function __construct()
    {
        parent::__construct();
    }
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
    // tostring
    public function __toString()
    {
        return parent::__toString() . ", Client [statusClient=$this->statusClient, telephone=$this->telephone, ville=$this->ville, createdAt=$this->createdAt]";
    }
    
    //inscrire
    public function inscrire() {}
}
