<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Vehicule;
use app\model\Categorie;
use app\model\Reservation;
use app\model\Avis;

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
                if (isset($_POST["action"]) && $_POST["action"] == "import")
                    $result =  $this->importVehicules();
                else
                    $result = $this->gererVehicule();
                header("Location: ../view/admin_fleet.php?$_POST[action]=$result");
                break;
            case "admin_reservations":
                $result = $this->gestionReservation();
                echo $_POST["action"];
                header("Location: ../view/admin_reservations.php?$_POST[statusReservation]=$result");
                break;
            case "admin_reviews":
                $result = $this->approverReview();
                header("Location: ../view/admin_reviews.php?$_POST[action]=$result");
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
            if ((isset($_POST["action"]) && $_POST["action"] == "update") || (isset($_POST["action"]) && $_POST["action"] == "delete")) {
                $id = (int)$_POST["idVehicule"];
                if ($id > 0)
                    $vehicule->setIdVehicule($id);
                else
                    throw new \InvalidArgumentException("ID vehicule invalide : $id");
            }
            if ((isset($_POST["action"]) && $_POST["action"] == "update") || (isset($_POST["action"]) && $_POST["action"] == "add")) {
                $vehicule->setMarqueVehicule($_POST["marqueVehicule"]);
                $vehicule->setModeleVehicule($_POST["modeleVehicule"]);
                $vehicule->setAnneeVehicule($_POST["anneeVehicule"]);
                $vehicule->setCouleurVehicule($_POST["couleurVehicule"]);
                $vehicule->setPrixVehicule($_POST["prixVehicule"]);
                $vehicule->setTypeBoiteVehicule($_POST["typeBoiteVehicule"]);
                $vehicule->setTypeCarburantVehicule($_POST["typeCarburantVehicule"]);
                $vehicule->setImageVehicule($_POST["imageVehicule"] ?? "iamege");  // mtnssach tzid image   edit
                $vehicule->setIdCategorie((int)$_POST["idCategorie"]);
            }

            if (isset($_POST["action"]) && $_POST["action"] == "add" && $vehicule->ajouterVehicule())
                return "success";
            elseif (isset($_POST["action"]) && $_POST["action"] == "update" && $vehicule->modifierVehicule())
                return "success";
            elseif (isset($_POST["action"]) && $_POST["action"] == "delete" && $vehicule->supprimerVehicule($vehicule->getIdVehicule()))
                return "success";
            else
                return "failed";
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
            return "failed";
        }
    }
    public function importVehicules()
    {
        try {
            if (isset($_POST["action"]) && $_POST["action"] == "import") {
                $bulkData = $_POST['bulkData'] ?? '';

                if (!empty($bulkData)) {
                    // Séparer par ligne
                    $lines = explode("\n", str_replace("\r", "", $bulkData));
                    $successCount = 0;

                    foreach ($lines as $line) {
                        if (empty(trim($line))) continue;

                        // Séparer par virgule
                        $data = explode(",", $line);

                        if (count($data) >= 7) {
                            $v = new Vehicule();
                            $v->setMarqueVehicule(trim($data[0]));
                            $v->setModeleVehicule(trim($data[1]));
                            $v->setAnneeVehicule(trim($data[2]));
                            $v->setCouleurVehicule(trim($data[3]));
                            $v->setTypeBoiteVehicule(trim($data[4]));
                            $v->setTypeCarburantVehicule(trim($data[5]));
                            $v->setPrixVehicule(trim($data[6]));
                            $v->setIdCategorie(trim($data[7] ?? 1));
                            $v->setImageVehicule(trim($data[8] ?? 'image'));
                            if ($v->ajouterVehicule()) {
                                $successCount++;
                            }
                        }
                    }

                    if ($successCount > 0) {
                        return "success";
                    } else {
                        return "failed";
                    }
                }
            }
        } catch (\Exception $e) {
            error_log(date('y-m-d h:i:s') . " Connexion :error ." . $e . PHP_EOL, 3, "error.log");
        }
    }
    public function gererCategories(): string
    {
        try {
            $categorie = new Categorie();
            if (isset($_POST["action"]) && $_POST["action"] !== "delete")
                $categorie->setTitreCategorie($_POST["nomCategorie"] ?? "");
            $categorie->setDescriptionCategorie("descption"); // $_POST["descriptionCategorie"];
            $categorie->setIdCategorie((int)$_POST["idCategorie"]);
            if (isset($_POST["action"]) && $_POST["action"] == "delete"  && $categorie->supprimerCategorie($categorie->getIdCategorie()))
                return "success";
            elseif (isset($_POST["action"]) && $_POST["action"] == "update" && $categorie->modifierCategorie()) {
                return "success";
            } elseif (isset($_POST["action"]) && $_POST["action"] == "add" && $categorie->ajouterCategorie()) {
                return "success";
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
                return "success";
            } elseif (isset($_POST["statusClient"]) && $_POST["statusClient"] == "activate" && $client->activateClient($idClient)) {
                return "success";
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
        $reservation->setIdReservation(intval($_POST["idReservation"]));
        if (isset($_POST["action"]) && $_POST["action"] == "confirmer" && $reservation->confirmerReservation($reservation->getIdReservation()))
            return "success";
        elseif (isset($_POST["action"]) && $_POST["action"] == "annuler" && $reservation->annulerReservation($reservation->getIdReservation()))
            return "success";
        else
            return "failed";
    }

    public function approverReview()
    {
        $avis = new Avis();
        $avis->setIdAvis(intval($_POST["idAvis"]));
        if (isset($_POST["action"]) && $_POST["action"] == "approve" && $avis->approveReview($avis->getIdAvis()))
            return "success";
        elseif (isset($_POST["action"]) && $_POST["action"] == "reject" && $avis->rejectReview($avis->getIdAvis()))
            return "success";
        else
            return "failed";
    }
}

$adminControler = new AdminControler();
$adminControler->index();
