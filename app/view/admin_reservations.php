<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Reservation;
use app\model\Client;
use app\model\Vehicule;

session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'admin') {
    header('Location: login.php');
    exit();
} else {

    $reservation = new Reservation();
    $client = new Client();
    $vehicule = new Vehicule();
    $reservations = $reservation->getAllReservations();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Manage Reservations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./css/style.css">
   
</head>

<body class="bg-slate-50 min-h-screen flex">

    <?php include('sidebar.php'); ?>

    <main class="flex-1 p-4 md:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Booking Management</h2>
            <p class="text-slate-500">Track and update all customer reservations.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 overflow-hidden">
            <table id="resTable" class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <th class="px-4 py-4">ID & Client</th>
                        <th class="px-4 py-4">Vehicle</th>
                        <th class="px-4 py-4">Dates & Duration</th>
                        <th class="px-4 py-4">Location (lieuChange)</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($reservations)   ?>
                    <?php foreach ($reservations as $reservation) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-4 py-4">
                                <p class="font-bold text-slate-800">#RES-<?= $reservation->getIdReservation() ?></p>
                                <p class="text-xs text-slate-400">Client ID: #<?= $reservation->getIdClient() ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-slate-700">
                                    <?php
                                    $vehicule =   $vehicule->getVehiculeById($reservation->getIdVehicule());
                                    echo  $vehicule->getMarqueVehicule() . ' ';
                                    echo  $vehicule->getModeleVehicule();
                                    ?>
                                </p>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-xs">
                                    <p class="font-bold"><?= (new \DateTime($reservation->getDateDebutReservation()))->format('d/m/Y') ?> → <?= (new \DateTime($reservation->getDateFinReservation()))->format('d/m/Y') ?></p>
                                    <p class="text-blue-500"><?= floor((strtotime($reservation->getDateDebutReservation()) - strtotime($reservation->getDateFinReservation())) / (60 * 60 * 24)) ?> jours</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-xs font-medium text-slate-600">
                                <i class="fas fa-map-marker-alt mr-1"></i><?= $reservation->getLieuChange() ?>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-blue-50 text-blue-600"><?= $reservation->getStatusReservation() ?></span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <button onclick="openDetailsModal({id:1, options:['GPS', 'Multimedia'], total:'$1350'})" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200"><i class="fas fa-eye text-xs"></i></button>
                                    <button onclick="openStatusModal(<?= $reservation->getIdReservation() ?>, '<?= $reservation->getStatusReservation() ?>')" class="p-2 bg-slate-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition"><i class="fas fa-sync text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="detailsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
            <h3 class="text-2xl font-bold text-slate-800 mb-4">Reservation Details</h3>
            <div id="detailsContent" class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-2xl">
                    <p class="text-[10px] font-black uppercase text-slate-400 mb-2">Selected Options</p>
                    <ul id="optionsList" class="space-y-2 text-sm font-bold text-slate-700">
                    </ul>
                </div>
                <div class="flex justify-between items-center p-4 bg-blue-600 text-white rounded-2xl">
                    <span class="font-bold">Total Price</span>
                    <span id="totalDisplay" class="text-xl font-black"></span>
                </div>
            </div>
            <button onclick="toggleModal('detailsModal')" class="w-full mt-6 py-3 bg-slate-100 text-slate-500 font-bold rounded-xl">Close</button>
        </div>
    </div>

    <div id="statusModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-800 mb-6 text-center">Update Status</h3>
            <form action="../controler/AdminControler.php" method="POST" class="space-y-4">
                <input type="hidden" name="idReservation" id="status_id">
                <input type="hidden" name="page" value="admin_reservations">
                <select name="action" id="status_select" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-bold">
                    <option value="en cours">En cours</option>
                    <option value="confirmer">confirmer</option>
                    <option value="annuler">annuler</option>
                </select>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="toggleModal('statusModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-100 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resTable').DataTable({
                pageLength: 7,

                ordering: true,
                dom: '<"flex justify-between items-center mb-6"f>rtip',
                language: {
                    search: "",
                    searchPlaceholder: "Search reservations..."
                }
            });
        });

        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function openDetailsModal(data) {
            const list = document.getElementById('optionsList');
            list.innerHTML = '';
            data.options.forEach(opt => {
                list.innerHTML += `<li class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-500"></i> ${opt}</li>`;
            });
            document.getElementById('totalDisplay').innerText = data.total;
            toggleModal('detailsModal');
        }

        function openStatusModal(id, currentStatus) {
            document.getElementById('status_id').value = id;
            document.getElementById('status_select').value = currentStatus;
            toggleModal('statusModal');
        }
    </script>
</body>

</html>