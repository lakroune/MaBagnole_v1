<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Reservation;
use app\model\Vehicule;
use app\model\Categorie;

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

            default:
                header("Location: ../view/index.php");
                break;
        }
    }

    public function gererCategories(): string
    {
        $categorie = new Categorie();
        $categorie = new Categorie();
        $categorie->titreCategorie = $_POST["nomCategorie"] ?? "";
        $categorie->descriptionCategorie = ""; // $_POST["descriptionCategorie"];
        $categorie->idCategorie = $_POST["idCategorie"] ?? "";
        if (isset($_POST["action"]) && $_POST["action"] == "delete"  && $categorie->supprimerCategorie($categorie->idCategorie))
            return "seccess";
        elseif (isset($_POST["action"]) && $_POST["action"] == "update" && $categorie->modifierCategorie()) {
            return "seccess";
        } elseif (isset($_POST["action"]) && $_POST["action"] == "add" && $categorie->ajouterCategorie()) {
            return "seccess";
        } else {
            return "failed";
        }
    }
    public function gererClients()
    {
        $idClient = intval($_POST["idClient"]);
        $client = new Client();
        if (isset($_POST["statusClient"]) && $_POST["statusClient"] == "suspend" && $client->suspendClient($idClient)) {
            return "seccess";
        } elseif (isset($_POST["statusClient"]) && $_POST["statusClient"] == "activate" && $client->activateClient($idClient)) {
            return "seccess";
        } else
            return "failed";
    }
}

$adminControler = new AdminControler();
$adminControler->index();
