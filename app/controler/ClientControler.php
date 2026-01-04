<?php

namespace app\controler;


require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Reservation;
use app\model\Favori;
use app\model\Avis;

class ClientControler
{

    public function __construct() {}

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
                break;
            case "details":
                if (isset($_POST['action']) && $_POST['action'] == 'rent' && $this->ajouterReservation())
                    header("Location: ../view/details.php?" . $_POST['action'] . "=success&id=" . $_POST['idVehicule']);
                elseif (isset($_POST['action']) && $_POST['action'] == 'addReview' && $this->ajouterAvis())
                    header("Location: ../view/details.php?" . $_POST['action'] . "=success&id=" . $_POST['idVehicule']);
                elseif (isset($_POST['action']) && $_POST['action'] == 'deleteReview' && $this->supprimerAvis())
                    header("Location: ../view/details.php?" . $_POST['action'] . "=success&id=" . $_POST['idVehicule']);
                elseif (isset($_POST['action']) && $_POST['action'] == 'updateReview' && $this->updateAvis())
                    header("Location: ../view/details.php?" . $_POST['action'] . "=success&id=" . $_POST['idVehicule']);
                else
                    header("Location: ../view/details.php?" . $_POST['action'] . "=failed&id=" . $_POST['idVehicule']);
                break;

            default:
                header("Location: ../view/accueil.php");
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
            $favori->setIdClient((int) $_SESSION['Utilisateur']->getIdUtilisateur());
            $favori->setIdVehicule((int) $_POST['idVehicule']);
            if ($favori->isFavori($favori->getIdClient(), $favori->getIdVehicule())) {
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

    public function ajouterReservation()
    {
        try {
            $reservation = new Reservation();
            session_start();
            $reservation->setIdClient((int) $_SESSION['Utilisateur']->getIdUtilisateur());
            $reservation->setDateDebutReservation($_POST["dateDebutReservation"]);
            $reservation->setDateFinReservation($_POST["dateFinReservation"]);
            $reservation->setLieuChange($_POST["lieuChange"]);
            $reservation->setIdVehicule((int) $_POST["idVehicule"]);

            if ($reservation->ajouterReservation())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function ajouterAvis()
    {
        try {
            $avis = new Avis();
            session_start();
            $avis->setCommentaireAvis($_POST["textReview"]);
            $avis->setNoteAvis((int)$_POST["ratings"]);
            $avis->setIdClient($_SESSION['Utilisateur']->getIdUtilisateur());
            $avis->setIdReservation((int)$_POST["idReservation"]);

            if ($avis->ajouterAvis())
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function supprimerAvis()
    {
        try {
            $avis = new Avis();
            $avis->setIdAvis((int)$_POST["idAvis"]);
            if ($avis->rejectReview($avis->getIdAvis()))
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
    public function updateAvis()
    {
        try {
            $avis = new Avis();
            $avis->setIdAvis((int)$_POST["idAvis"]);
            $avis->setCommentaireAvis($_POST["textReview"]);
            // $avis->setNoteAvis((int)$_POST["ratings"]);
            if ($avis->modifierAvis($avis->getIdAvis()))
                return true;
            else
                return false;
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return false;
        }
    }
}



$clientControler = new ClientControler();
$clientControler->index();
