<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Categorie;
use app\model\Vehicule;

session_start();
$connect = true;
if (!isset($_SESSION['Utilisateur']) or  $_SESSION['Utilisateur']->getRole() !== 'client') {
    $connect =  false;
}
$vehicule = new Vehicule();
$vehicules = $vehicule->getAllVehicules();

$categorie = new Categorie();
$categories = $categorie->getAllCategories();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Welcome</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        .font-outline-2 {
            -webkit-text-stroke: 1px #3b82f6;
            color: transparent;
        }

        .is-favorite {
            color: #ef4444 !important;
            background-color: white !important;
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .car-card:hover {
            transform: translateY(-10px);
        }

        /* DataTable Custom Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important;
            color: white !important;
            border: none !important;
            border-radius: 0.75rem;
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }

        .dataTables_info {
            color: #64748b !important;
            font-size: 0.875rem;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">

    <nav class="flex justify-between items-center px-8 py-4 bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>
        <div class="hidden md:flex gap-8 items-center">
            <?php if ($connect) : ?>
                <a href="accueil.php" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Browse Cars</a>
                <a href="my_reservations.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">My Bookings</a>
                <a href="favorites.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Favorites</a>
            <?php endif; ?>
        </div>
        <?php include('infoClient.php'); ?>
    </nav>

    <header class="relative py-20 bg-slate-900 overflow-hidden">
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-blue-500 font-bold tracking-widest uppercase text-sm mb-3">Premium Rental Service</h2>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">Find the perfect ride for <br><span class="text-blue-500 font-outline-2">your next journey.</span></h1>
            </div>

            <div class="max-w-5xl mx-auto bg-white p-2 rounded-2xl md:rounded-full shadow-2xl">
                <form id="searchForm" class="flex flex-col md:flex-row items-center">
                    <div class="flex-1 w-full px-6 py-3 flex items-center border-b md:border-b-0 md:border-r border-slate-100">
                        <i class="fas fa-search text-slate-400 mr-3"></i>
                        <input type="text" id="customSearch" placeholder="Marque or Model..." class="w-full outline-none bg-transparent text-slate-700">
                    </div>

                    <div class="flex-1 w-full px-6 py-3 flex items-center border-b md:border-b-0 md:border-r border-slate-100">
                        <i class="fas fa-th-large text-slate-400 mr-3"></i>
                        <select id="categoryFilter" class="w-full outline-none bg-transparent text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?= $categorie->getTitreCategorie() ?>"><?= $categorie->getTitreCategorie() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </form>
            </div>
        </div>
    </header>

    <section id="fleet" class="max-w-7xl mx-auto px-4 py-20">
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-slate-900">Available Vehicles</h2>
            <p class="text-slate-500 mt-2">Explore our premium collection based on your needs.</p>
        </div>

        <table id="vehicleTable" class="w-full border-none">
            <thead class="hidden">
                <tr>
                    <th>Vehicle</th>
                </tr>
            </thead>
            <tbody class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach ($vehicules as $vehicule) : ?>
                    <tr class="block">
                        <td class="block border-none p-0">
                            <div class="car-card bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col transition-all duration-300 group h-full">
                                <div class="relative overflow-hidden">
                                    <img src="<?= $vehicule->getImageVehicule() ?>" alt="Car" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                                    <div class="absolute top-4 left-4 flex gap-2">
                                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-blue-600 shadow-sm"><?= $vehicule->getMarqueVehicule() ?></span>
                                        <span class="bg-slate-900 text-white px-3 py-1 rounded-full text-[10px] font-bold"><?= $vehicule->getAnneeVehicule() ?></span>
                                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-slate-900">
                                            <?php
                                            $categorieFeilter = new Categorie();
                                            $categorieFeilter = $categorieFeilter->getCategoriebyId($vehicule->getIdCategorie());
                                            echo $categorieFeilter->getTitreCategorie();
                                            ?>
                                        </span>
                                    </div>


                                    <form id="favoriteForm" action="#" method="POST">
                                        <input type="hidden" name="idVehicule" value="<?= $vehicule->getIdVehicule() ?>">
                                        <input type="hidden" name="page" value="accueil">
                                        <input type="hidden" name="action" value="favorite">
                                        <!-- .favorite-btn ??? mtnsahch  wahynari  -->
                                        <button type="button" <?php if (!($connect)) :  ?> onclick="toggleModal('rentPopup')" <?php else:; ?> onclick="toggleFavorite(this)" <?php endif; ?> class="  favorite-btn absolute top-4 right-4 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 transition shadow-lg">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="p-8 flex-1 flex flex-col">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-2xl font-bold text-slate-800"><?= $vehicule->getMarqueVehicule() . ' ' . $vehicule->getModeleVehicule() ?></h3>
                                            <p class="text-slate-400 text-sm flex items-center gap-1 mt-1"><i class="fas fa-palette"></i> Midnight Black</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-black text-blue-600"><?= $vehicule->getPrixVehicule() ?> </p>
                                            <p class="text-xs text-slate-400 uppercase font-bold">MAD/Day</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 py-6 border-y border-slate-50 my-2">
                                        <div class="flex items-center gap-3 text-slate-600">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-xs"><i class="fas fa-cog"></i></div>
                                            <span class="text-sm font-medium"><?= $vehicule->getTypeBoiteVehicule() ?></span>
                                        </div>
                                        <div class="flex items-center gap-3 text-slate-600">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-xs"><i class="fas fa-gas-pump"></i></div>
                                            <span class="text-sm font-medium"><?= $vehicule->getTypeCarburantVehicule() ?></span>
                                        </div>
                                    </div>

                                    <div class="mt-auto pt-6 flex gap-3">
                                        <a href="details.php?id=<?= $vehicule->getIdVehicule() ?>" class="flex-1 text-center py-3.5 px-4 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">Details</a>
                                        <button <?php if (!($connect)) :  ?> onclick="toggleModal('rentPopup')" <?php else: ?> onclick="window.location.href='./details.php?id=<?= $vehicule->getIdVehicule() ?> '" <?php endif; ?> class="flex-[1.5] text-center py-3.5 px-4 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-3xl font-black text-blue-500">MaBagnole</span>
            <p class="text-slate-500 text-sm mt-8">© 2025 MaBagnole Management. All rights reserved.</p>
        </div>
    </footer>
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
        // AJAX for favorite button
        $(document).ready(function() {

            $('.favorite-btn').on('click', function(e) {
                e.preventDefault();

                const $btn = $(this);
                const $form = $btn.closest('form');
                const formData = $form.serialize();
                $.ajax({
                    url: '../controler/ClientControler.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            console.log('success');
                        } else {
                            console.log('failed');
                        }
                    },
                    error: function() {
                        console.log('error');
                    }
                });
            });
        });

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

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#vehicleTable').DataTable({
                "dom": 'tip', // Hide default search bar
                "pageLength": 6,
                "ordering": false, // order by default
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-arrow-left'></i>",
                        "next": "<i class='fas fa-arrow-right'></i>"
                    }
                }
            });

            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#categoryFilter').on('change', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</body>

</html>