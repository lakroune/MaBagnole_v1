<?php

namespace app\model;

use app\model\Connexion;

class Utilisateur
{
    protected int $idUtilisateur;
    protected string $nomUtilisateur;
    protected string $prenomUtilisateur;
    protected string $email;
    protected string $password;
    protected string $role;
    // constructeur
    public function __construct() {}
    // getters

    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    public function getPrenomUtilisateur()
    {
        return $this->prenomUtilisateur;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }




    // setters
    public function setIdUtilisateur($idUtilisateur): bool
    {
        if (is_int($idUtilisateur) and $idUtilisateur > 0) {
            $this->idUtilisateur = $idUtilisateur;
            return true;
        }
        return false;
    }
    public function setNomUtilisateur($nomUtilisateur): bool
    {
        if (strlen($nomUtilisateur) >= 2 && strlen($nomUtilisateur) <= 50) {
            $this->nomUtilisateur = $nomUtilisateur;
            return true;
        } else {
            return false;
        }
    }
    public function setPrenomUtilisateur($prenomUtilisateur): bool
    {
        if (strlen($prenomUtilisateur) >= 2 && strlen($prenomUtilisateur) <= 50) {
            $this->prenomUtilisateur = $prenomUtilisateur;
            return true;
        } else {
            return false;
        }
    }
    public function setEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    public function setPassword($password): bool
    {
        if (strlen($password) >= 6) {
            $this->password = $password;
            return true;
        } else {
            return false;
        }
    }
    public function setRole($role): bool
    {
        // if($role == 'admin' || $role == 'client')
        if (in_array($role, ['admin', 'client'])) {
            $this->role = $role;
            return true;
        }
        return true;
    }



    //toString
    public function __toString()
    {
        return "idUtilisateur=$this->idUtilisateur, nomUtilisateur=$this->nomUtilisateur, prenomUtilisateur=$this->prenomUtilisateur, email=$this->email, role=$this->role";
    }
    //seconnecter
    public function seConnecter(): string
    {
        try {
            $db = Connexion::connect()->getConnexion();
            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_OBJ);
            if ($user && password_verify($this->password, $user->password)) {
                session_start();
                $_SESSION['Utilisateur'] = $user;
                return $user->role;
            } else {

                return "error";
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "error";
        }
    }
    //sdeconnecter
    public function seDeconnecter()
    {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
