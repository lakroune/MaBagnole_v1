<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Categorie;
use app\model\Vehicule;

$vehicules = (new Vehicule())->getAllVehicules();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Catalogue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sticky-bar {
            position: sticky;
            top: 72px;
            z-index: 40;
        }

        .modal-active {
            display: flex !important;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    <nav class="flex justify-between items-center px-8 py-5 bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>
        <div class="flex items-center gap-4">
            <a href="login.php" class="text-sm font-bold text-slate-600">Sign In</a>
            <a href="register.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Register</a>
        </div>
    </nav>

    <div class="sticky-bar bg-white/80 backdrop-blur-md border-b border-slate-200 py-4 px-8 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Search brand..." class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0">
                <button class="px-5 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-md">All</button>
                <button class="px-5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">Luxury</button>
                <button class="px-5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">SUV</button>
                <button class="px-5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">Sport</button>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">



            <?php if (empty($vehicules)) : ?>
                <div class="bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm group">
                </div>
            <?php else : ?>
                <?php foreach ($vehicules as $vehicule) : ?>
                    <div class="bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm group">
                        <div class="relative h-52 overflow-hidden">
                            <img src="<?= $vehicule->imageVehicule ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-black text-slate-800"><?= $vehicule->marqueVehicule . "" . $vehicule->modeleVehicule ?></h3>
                            <p class="text-blue-600 font-bold mb-4"><?= $vehicule->prixVehicule ?> MAD <span class="text-slate-400 text-[10px] uppercase">/ Day</span></p>

                            <div class="flex gap-2 mb-6">
                                <button onclick="toggleModal('rentPopup')" class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-xs font-bold hover:bg-blue-600 transition">Rent Now</button>
                                <a href="details.php?id=<?= $vehicule->idVehicule ?>" class="flex-1 bg-slate-100 text-slate-600 py-3 rounded-xl text-xs font-bold text-center hover:bg-slate-200 transition">Voir Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <div class="mt-16 flex justify-center items-center gap-2">
            <button class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-white transition"><i class="fas fa-chevron-left"></i></button>
            <button class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-100">1</button>
            <button class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold hover:border-blue-500 transition">2</button>
            <button class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold hover:border-blue-500 transition">3</button>
            <button class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-white transition"><i class="fas fa-chevron-right"></i></button>
        </div>
    </main>

    <div id="rentPopup" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl text-center relative">
            <button onclick="toggleModal('rentPopup')" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600"><i class="fas fa-times"></i></button>

            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Login Required</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">You need to be logged in to book this vehicle and manage your reservations.</p>

            <div class="flex flex-col gap-3">
                <a href="login.php" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition">Sign In Now</a>
                <a href="register.php" class="w-full bg-slate-50 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-100 transition">Create an Account</a>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('rentPopup');
            if (event.target == modal) {
                toggleModal('rentPopup');
            }
        }
    </script>
</body>

</html>