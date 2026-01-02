<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Vehicule;
use app\model\Categorie;
use app\model\Reservation;
use app\model\Favori;

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
            case "accueil":
                if (isset($_POST['action']) && $_POST['action'] == 'favorite')
                    $this->gestionFavoris();
                // echo json_encode(['success' => true, 'message' => 'Favori non ajouter']);
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

    public function gestionFavoris()
    {
        header('Content-Type: application/json');
        try {
            session_start();
            $favori = new Favori();
            $favori->idClient = $_SESSION['Utilisateur']->idUtilisateur;
            $favori->idVehicule = $_POST['idVehicule'];
            if ($favori->getFavori($favori->idClient, $favori->idVehicule)) {
                $favori->annulerFavori();
            } else {
                $favori->ajouterFavori();
            }
            echo json_encode(['success' => true, 'message' => 'Favori ajouter']);
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            echo json_encode(['success' => false, 'message' => 'Favori non ajouter']);
        }
    }
}

$clientControler = new ClientControler();
