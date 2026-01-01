<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Utilisateur;


class UtilisateurControler
{

    public function __construct()
    {
        $this->index();
    }

    public function  index()
    {
        $page = $_POST["page"] ??"";
        switch ($page) {
            case "login":
                $isLogined = $this->seConnecter();
                if ($isLogined == "client") {
                    header("Location: ../view/accueil.php?login=success");
                } else if ($isLogined == "admin") {
                    header("Location: ../view/admin_dashboard.php?login=success");
                } else {
                    header("Location: ../view/login.php?login=failed");
                }
                break;
            default:
                header("Location: ../view/index.php");
                break;
        }
    }


    public function seConnecter()
    {
        $utilisateur = new Utilisateur();
        if (
            $utilisateur->setEmail($_POST["email"]) &&
            $utilisateur->setPassword($_POST["password"])
        )
            return   $utilisateur->seConnecter();
        else
            return false;
    }
}

$utilisateurControler = new UtilisateurControler();
