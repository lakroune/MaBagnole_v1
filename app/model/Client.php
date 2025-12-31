<?php
require_once "Connexion.php";
require_once "Utilisateur.php";
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
    public function inscrire(): bool
    {
        try {
            $sql = "insert into utilisateur  (nomUtilisateur,prenomUtilisateur ,telephone , ville ,email ,paword ,role)
             values (:nomUtilisateur,:prenomUtilisateur,:telephone,:ville,:email,:paword,'client')";
            $stmt = (Connexion::connect()->getConnexion())->prepare($sql);
            $stmt->bindParam(":nomUtilisateur", $this->nomUtilisateur);
            $stmt->bindParam(":prenomUtilisateur", $this->prenomUtilisateur);
            $stmt->bindParam(":telephone", $this->telephone);
            $stmt->bindParam(":nomUtilisateur", $this->nomUtilisateur);
            $stmt->bindParam(":ville", $this->ville);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":paword", $this->paword);
            $stmt->bindParam(":role", $this->role);
            if ($stmt->exicute())
                return true;
            else
                return false;
        } catch (Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
}

