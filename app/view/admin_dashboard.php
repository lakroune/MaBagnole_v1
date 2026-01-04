<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Client;
use app\model\Vehicule;
use app\model\Categorie;
use app\model\Reservation;


session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'admin') {
    header('Location: login.php');
    exit();
} else {
    $client = new Client();
    $reservation = new Reservation();
    $vehicule = new Vehicule();
    $categorie = new Categorie();
    

    $statistiques = [
        'totalClients' => $client->counterClients(),
        'totalVehicules' => $vehicule->counterVehicules(),
        'totalCategories' => $categorie->counterCategorie(),
        'totalReservations' => $reservation->counterReservations(),
        'ClientsNouveaux' => $client->getNbClientsCreateToDay(),
        'RerservationsCreatesToday' => $reservation->getNbReservationToDay(),
        'RerservationsActive' => $reservation->getNbReservationActive(),
        'RerservationsConfirmer' => $reservation->getNbReservationConfirmer(),
        'RerservationsEnCours' => $reservation->getNbReservationEnCours(),
        'RerservationsAnnuler' => $reservation->getNbReservationAnnuler(),
        'RevenueReservation' => $reservation->getRevenueReservation(),
        'VehiculesDisponibles' => $vehicule->getNbVehiculeDisponible()
    ];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-slate-50 min-h-screen flex">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-4 md:p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Global Statistics</h2>
                <p class="text-slate-500">Key metrics and business performance summary.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-black text-slate-600 uppercase tracking-widest">System Live</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Revenue</p>
                <h3 class="text-3xl font-black text-slate-800">$<?php echo $statistiques['RevenueReservation']; ?></h3>
                <p class="text-green-500 text-xs font-bold mt-2">+12.5% vs last month</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Total Bookings</p>
                <h3 class="text-3xl font-black text-slate-800"><?php echo $statistiques['totalReservations']; ?></h3>
                <p class="text-blue-500 text-xs font-bold mt-2">Active reservations: <?php echo $statistiques['RerservationsActive']; ?></p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Fleet Size</p>
                <h3 class="text-3xl font-black text-slate-800"><?php echo $statistiques['totalVehicules']; ?></h3>
                <p class="text-slate-400 text-xs font-bold mt-2">Available for rent: <?php echo $statistiques['VehiculesDisponibles']; ?></p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Active Users</p>
                <h3 class="text-3xl font-black text-slate-800"><?php echo $statistiques['totalClients']; ?></h3>
                <p class="text-purple-500 text-xs font-bold mt-2">New users today: +<?php echo $statistiques['ClientsNouveaux']; ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-list-ul text-blue-500"></i> Reservation Breakdown
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-sm font-bold text-slate-600">Confirmed & Paid</span>
                        <span class="font-black text-blue-600 text-lg"><?php echo $statistiques['RerservationsActive']; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-sm font-bold text-slate-600">Pending Approval</span>
                        <span class="font-black text-orange-500 text-lg"><?php echo $statistiques['RerservationsEnCours']; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-sm font-bold text-slate-600">Canceled</span>
                        <span class="font-black text-red-500 text-lg"><?php echo $statistiques['RerservationsAnnuler']; ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-tags text-blue-500"></i> Fleet by Category
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="flex-1 bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full" style="width: 45%"></div>
                        </div>
                        <span class="text-xs font-black text-slate-500 w-24">Luxury (12)</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-1 bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-orange-500 h-full" style="width: 60%"></div>
                        </div>
                        <span class="text-xs font-black text-slate-500 w-24">SUV (18)</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex-1 bg-slate-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: 35%"></div>
                        </div>
                        <span class="text-xs font-black text-slate-500 w-24">Economy (15)</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

</html>