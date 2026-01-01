<?php

namespace app\controler;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Reservation;
use app\model\Vehicule;

class AdminControler
{
    function __construct() {}
    public function index()
    {
        $page = $_POST["page"] ?? "dashboard_admin";

        switch ($page) {
            case "dashboard_admin":

                $stats = [
                    'total_clients'      => Client::counterClients(),
                    'total_reservations' => Reservation::counterReservations()
                ];

                require_once __DIR__ . '/../view/admin_dashboard.php';
                break;
            case "fleet_admin":
                require_once __DIR__ . '/../view/admin_fleet.php';
                break;
            case "clients_admin":
                require_once __DIR__ . '/../view/admin_clients.php';
                break;
            case "categories_admin":
                require_once __DIR__ . '/../view/admin_categories.php';
                break;
            case "reservations_admin":
                require_once __DIR__ . '/../view/admin_reservations.php';
                break;
            default:
                header("Location: ../view/index.php");
                break;
        }
    }
}

$adminControler = new AdminControler();
$adminControler->index();
