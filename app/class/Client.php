<?php
 
class Client extends Utilisateur
{
    private int $statusClient;
    private string $telephone;
    private string $ville;
    private DateTime $createdAt;
    public function __construct()
    {
        parent::__construct();
    }
    
}
