<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Vehicule;
use app\model\Categorie;
use app\model\Reservation;

class AdminControler
{
    function __construct() {}
    public function index()
    {
        $page = $_POST["page"] ?? "dashboard_admin";

        switch ($page) {
            case "dashboard_admin":
                header("Location: ../view/admin_dashboard.php");
                break;
            case "admin_categories":
                $result = $this->gererCategories();
                header("Location: ../view/admin_categories.php?$_POST[action]=$result");
                break;
            case "admin_clients":
                $result = $this->gererClients();
                header("Location: ../view/admin_clients.php?$_POST[statusClient]=$result");
                break;
            case "admin_fleet":
                $result = $this->gererVehicule();
                header("Location: ../view/admin_fleet.php?$_POST[action]=$result");
                break;
            case "admin_reservations":
                $result = $this->gestionReservation();
                echo $_POST["action"];
                header("Location: ../view/admin_reservations.php?$_POST[statusReservation]=$result");
                break;

            default:
                header("Location: ../view/index.php");
                break;
        }
    }


    public function gererVehicule()
    {
        try {
            $vehicule = new Vehicule();
            $vehicule->idVehicule = intval($_POST["idVehicule"]) ?? "";
            $vehicule->marqueVehicule = $_POST["marqueVehicule"] ?? "";
            $vehicule->modeleVehicule = $_POST["modeleVehicule"] ?? "";
            $vehicule->anneeVehicule = $_POST["anneeVehicule"] ?? "";
            $vehicule->couleurVehicule = $_POST["couleurVehicule"] ?? "";
            $vehicule->prixVehicule = $_POST["prixVehicule"] ?? "";
            $vehicule->typeBoiteVehicule = $_POST["typeBoiteVehicule"] ?? "";
            $vehicule->typeCarburantVehicule = $_POST["typeCarburantVehicule"] ?? "";
            $vehicule->imageVehicule = $_POST["imageVehicule"] ?? "";
            $vehicule->idCategorie = intval($_POST["idCategorie"]) ?? "";
            if (isset($_POST["action"]) && $_POST["action"] == "add" && $vehicule->ajouterVehicule())
                return "seccess";
            elseif (isset($_POST["action"]) && $_POST["action"] == "update" && $vehicule->modifierVehicule())
                return "seccess";
            elseif (isset($_POST["action"]) && $_POST["action"] == "delete" && $vehicule->supprimerVehicule($vehicule->idVehicule ?? 2))
                return "seccess";
            else
                return "failed";
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "failed";
        }
    }

    public function gererCategories(): string
    {
        try {
            $categorie = new Categorie();
            $categorie = new Categorie();
            $categorie->titreCategorie = $_POST["nomCategorie"] ?? "";
            $categorie->descriptionCategorie = ""; // $_POST["descriptionCategorie"];
            $categorie->idCategorie = intval($_POST["idCategorie"]) ?? "";
            if (isset($_POST["action"]) && $_POST["action"] == "delete"  && $categorie->supprimerCategorie($categorie->idCategorie))
                return "seccess";
            elseif (isset($_POST["action"]) && $_POST["action"] == "update" && $categorie->modifierCategorie()) {
                return "seccess";
            } elseif (isset($_POST["action"]) && $_POST["action"] == "add" && $categorie->ajouterCategorie()) {
                return "seccess";
            } else {
                return "failed";
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "failed";
        }
    }
    public function gererClients()
    {
        try {
            $idClient = intval($_POST["idClient"]) ?? "";
            $client = new Client();
            if (isset($_POST["statusClient"]) && $_POST["statusClient"] == "suspend" && $client->suspendClient($idClient)) {
                return "seccess";
            } elseif (isset($_POST["statusClient"]) && $_POST["statusClient"] == "activate" && $client->activateClient($idClient)) {
                return "seccess";
            } else
                return "failed";
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "failed";
        }
    }
    public function gestionReservation()
    {
        $reservation = new Reservation();
        $reservation->idReservation = intval($_POST["idReservation"]) ?? "";
        if (isset($_POST["action"]) && $_POST["action"] == "confirmer" && $reservation->confirmerReservation($reservation->idReservation))
            return "seccess";
        elseif (isset($_POST["action"]) && $_POST["action"] == "annuler" && $reservation->annulerReservation($reservation->idReservation))
            return "seccess";
        else
            return "failed";
    }
}

$adminControler = new AdminControler();
$adminControler->index();
