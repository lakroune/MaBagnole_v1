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

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    public function getPrenomUtilisateur(): string
    {
        return $this->prenomUtilisateur;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }




    // setters
    public function setIdUtilisateur(int $idUtilisateur): bool
    {
        if ($idUtilisateur > 0) {
            $this->idUtilisateur = $idUtilisateur;
            return true;
        }
        return false;
    }
    public function setNomUtilisateur(string $nomUtilisateur): bool
    {
        if (strlen($nomUtilisateur) >= 2 && strlen($nomUtilisateur) <= 50) {
            $this->nomUtilisateur = $nomUtilisateur;
            return true;
        } else {
            return false;
        }
    }
    public function setPrenomUtilisateur(string $prenomUtilisateur): bool
    {
        if (strlen($prenomUtilisateur) >= 2 && strlen($prenomUtilisateur) <= 50) {
            $this->prenomUtilisateur = $prenomUtilisateur;
            return true;
        } else {
            return false;
        }
    }
    public function setEmail(string $email): bool
    {
        $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (preg_match($regex, $email)) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    public function setPassword(string $password): bool
    {
        if (strlen($password) >= 6) {
            $this->password = $password;
            return true;
        } else {
            return false;
        }
    }
    public function setRole(string  $role): bool
    {
        // if($role == 'admin' || $role == 'client')
        if (in_array($role, ['admin', 'client'])) {
            $this->role = $role;
            return true;
        }
        return false;
    }



    //toString
    public function __toString(): string
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
            $user = $stmt->fetchObject(Utilisateur::class);
            if ($user && password_verify($this->password, $user->getPassword())) {
                session_start();
                $_SESSION['Utilisateur'] = $user;
                return $user->getRole();
            } else {

                return "error";
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "error";
        }
    }
    //sdeconnecter
    public function seDeconnecter(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        return true;
    }
}
