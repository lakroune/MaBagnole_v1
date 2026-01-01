<?php

namespace app\model;

use app\model\Utilisateur;
use app\model\Connexion;

class Client extends Utilisateur
{
    private int $statusClient;
    private string $telephone;
    private string $ville;
    private \DateTime $createdAt;
    // constructeur Client
    public function __construct()
    {
        parent::__construct();
    }
    // getters
    public function __get($aturibute)
    {
        return $this->$aturibute;
    }
    // setters
    public function setStatusClient($statusClient): bool
    {
        if (is_int($statusClient) and ($statusClient == 0 || $statusClient == 1)) {
            $this->statusClient = $statusClient;
            return true;
        }
        return false;
    }
    public function setTelephone($telephone): bool
    {
        $regex = '/^\+212[5-7][0-9]{8}$/';
        if (preg_match($regex, $telephone)) {
            $this->telephone = $telephone;
            return true;
        }
        return false;
    }
    public function setVille($ville): bool
    {
        if (strlen($ville) >= 2 && strlen($ville) <= 50) {
            $this->ville = $ville;
            return true;
        }
        return false;
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
            $passwordHash = password_hash($this->password, PASSWORD_BCRYPT);
            $sql = "insert into utilisateurs  (nomUtilisateur,prenomUtilisateur ,telephone , ville ,email ,password ,role)
             values (:nomUtilisateur,:prenomUtilisateur,:telephone,:ville,:email,:password,:role)";
            $db = Connexion::connect()->getConnexion();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":nomUtilisateur", $this->nomUtilisateur);
            $stmt->bindParam(":prenomUtilisateur", $this->prenomUtilisateur);
            $stmt->bindParam(":telephone", $this->telephone);
            $stmt->bindParam(":ville", $this->ville);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":role", $this->role);
            if ($stmt->execute())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function getClientById(int $idClient)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from utilisateurs where idUtilisateur=:idClient and role='client'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idClient", $idClient);
            $stmt->execute();
            $client = $stmt->fetch(\PDO::FETCH_OBJ);
            if ($client) {
                return $client;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function getClientByEmail(string $email)
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from utilisateurs where email=:email and role='client'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $client = $stmt->fetch(\PDO::FETCH_OBJ);
            if ($client) {
                return $client;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public static function getAllClients(): array
    {
        $clients = [];
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select * from utilisateurs where role='client'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
            return $results;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return $clients;
        }
    }

     
    public static function counterClients(): int
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "select count(*) as total from utilisateurs where role='client'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            return (int)$result->total;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return 0;
        }
    }
}
