<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;

class ClientControler
{

    public function __construct()
    {
        $this->index();
    }

    public function  index()
    {
        $page = $_POST["page"] ?? "";

        switch ($page) {
            case "register":
                if ($this->inscrire()) {
                    header("Location: ../view/register.php?register=success");
                } else {
                    header("Location: ../view/register.php?register=failed");
                }
                break;
            case "":
                header("Location: ../view/index.php");
                break;

            default:
                header("Location: ../view/index.php");
                break;
        }
    }


    public function inscrire()
    {
        $client = new Client();
        if (
            $client->setNomUtilisateur($_POST['nomUtilisateur']) &&
            $client->setPrenomUtilisateur($_POST['prenomUtilisateur']) &&
            $client->setTelephone($_POST['telephone']) &&
            $client->setVille($_POST['ville']) &&
            $client->setEmail($_POST['email']) &&
            $client->setRole('client') &&
            $client->setPassword($_POST['paword']) &&
            $client->inscrire()
        )
            return true;
        else
            return false;
    }
}

$clientControler = new ClientControler();
