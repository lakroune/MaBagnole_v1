<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Categorie;
use app\model\Vehicule;



session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'client') {
    header('Location: login.php');
    exit();
} else {

    $vehicule = new Vehicule();
    $vehicules = $vehicule->getAllVehicules();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-pill {
            @apply px-3 py-1 rounded-full text-[10px] font-black uppercase border;
        }

        .status-en-cours {
            @apply bg-blue-50 text-blue-600 border-blue-100;
        }

        .status-terminee {
            @apply bg-green-50 text-green-600 border-green-100;
        }

        .status-annulee {
            @apply bg-red-50 text-red-600 border-red-100;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    <nav class="flex justify-between items-center px-8 py-4 bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>
        <div class="hidden md:flex gap-8 items-center">
            <a href="accueil.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Browse Cars</a>
            <a href="my_reservations.php" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">My Bookings</a>
            <a href="favorites.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Favorites</a>
        </div>
        <?php include('infoClient.php'); ?>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-12">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-800">My Reservations</h1>
            <p class="text-slate-500">Manage your current bookings and view your rental history.</p>
        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-6 items-center">
                <div class="w-full md:w-48 h-32 rounded-2xl overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400" alt="Car" class="w-full h-full object-cover">
                </div>

                <div class="flex-1 space-y-2 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">Porsche 911 Carrera</h3>
                        <span class="status-pill status-en-cours w-fit mx-auto md:mx-0">En cours</span>
                    </div>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-slate-500 font-medium">
                        <span><i class="far fa-calendar-alt text-blue-500 mr-1"></i> 30/12/2025 - 02/01/2026</span>
                        <span><i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> Casablanca Airport</span>
                    </div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Options: GPS, Child Seat</p>
                </div>

                <div class="w-full md:w-auto text-center md:text-right border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Total Amount</p>
                    <p class="text-2xl font-black text-blue-600">$897.00</p>
                    <button onclick="confirmCancellation(101)" class="mt-3 text-xs font-bold text-red-500 hover:text-red-700 transition">
                        <i class="fas fa-times-circle mr-1"></i> Cancel Booking
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-6 items-center opacity-75 grayscale-[0.5]">
                <div class="w-full md:w-48 h-32 rounded-2xl overflow-hidden shrink-0">
                    <img src="https://images.unsplash.com/photo-1542362567-b055002b91f4?w=400" alt="Car" class="w-full h-full object-cover">
                </div>

                <div class="flex-1 space-y-2 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">BMW M8 Coupe</h3>
                        <span class="status-pill status-terminee w-fit mx-auto md:mx-0">Terminée</span>
                    </div>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-slate-500 font-medium">
                        <span><i class="far fa-calendar-alt text-slate-400 mr-1"></i> 15/12/2025 - 18/12/2025</span>
                    </div>
                </div>

                <div class="w-full md:w-auto text-center md:text-right md:pl-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Paid</p>
                    <p class="text-2xl font-black text-slate-400">$1,050.00</p>
                    <button class="mt-3 text-xs font-bold text-blue-500 hover:underline">Download Invoice</button>
                </div>
            </div>

        </div>
    </main>

    <div id="cancelModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Cancel Reservation?</h3>
            <p class="text-slate-400 text-sm mb-8">This action cannot be undone. You might be subject to cancellation fees.</p>

            <form action="process_cancel.php" method="POST" class="flex gap-3">
                <input type="hidden" name="idReservation" id="cancel_id">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 font-bold text-slate-400 bg-slate-50 rounded-xl">Back</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg shadow-red-100">Confirm</button>
            </form>
        </div>
    </div>

    <script>
        function confirmCancellation(id) {
            document.getElementById('cancel_id').value = id;
            const modal = document.getElementById('cancelModal');
            modal.classList.replace('hidden', 'flex');
        }

        function closeModal() {
            document.getElementById('cancelModal').classList.replace('flex', 'hidden');
        }
    </script>

</body>

</html>