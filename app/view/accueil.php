<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Categorie;
use app\model\Vehicule;



session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->role !== 'client') {
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
    <title>MaBagnole | Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .font-outline-2 {
            -webkit-text-stroke: 1px #3b82f6;
            color: transparent;
        }

        .is-favorite {
            color: #ef4444 !important;
            background-color: white !important;
        }

        .is-favorite i {
            animation: heartBeat 0.3s ease-in-out;
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
    </style>
</head>

<body class="bg-slate-50 font-sans">

    <nav class="flex justify-between items-center px-8 py-4 bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>

        <div class="hidden md:flex gap-8 items-center">
            <a href="accueil.php" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Browse Cars</a>
            <a href="my_reservations.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">My Bookings</a>
            <a href="favorites.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Favorites</a>
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
                <form action="" method="GET" class="flex flex-col md:flex-row items-center">
                    <div class="flex-1 w-full px-6 py-3 flex items-center border-b md:border-b-0 md:border-r border-slate-100">
                        <i class="fas fa-search text-slate-400 mr-3"></i>
                        <input type="text" name="search" placeholder="Marque or Model..."
                            class="w-full outline-none bg-transparent text-slate-700 placeholder:text-slate-400">
                    </div>

                    <div class="flex-1 w-full px-6 py-3 flex items-center border-b md:border-b-0 md:border-r border-slate-100">
                        <i class="fas fa-th-large text-slate-400 mr-3"></i>
                        <select name="category" class="w-full outline-none bg-transparent text-slate-700 appearance-none cursor-pointer">
                            <option value="">All Categories</option>
                            <option value="1">Luxury</option>
                            <option value="2">SUV</option>
                            <option value="3">Electric</option>
                        </select>
                    </div>

                    <div class="flex-1 w-full px-6 py-3 flex items-center">
                        <i class="fas fa-calendar-alt text-slate-400 mr-3"></i>
                        <input type="text" placeholder="Pickup Date" onfocus="(this.type='date')"
                            class="w-full outline-none bg-transparent text-slate-700 cursor-pointer">
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-xl md:rounded-full font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </header>

    <section id="fleet" class="max-w-7xl mx-auto px-4 py-20">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Available Vehicles</h2>
                <p class="text-slate-500 mt-2">Explore our premium collection based on your needs.</p>
            </div>
            <div class="hidden sm:block text-sm font-medium text-slate-400 uppercase tracking-widest">
                Showing 1 of 24 Cars
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            <?php foreach ($vehicules as $vehicule) : ?>
                <div class="car-card bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col transition-all duration-300 group">
                    <div class="relative overflow-hidden">
                        <img src="<?= $vehicule->imageVehicule ?>"
                            alt="Car" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">

                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-blue-600 shadow-sm"><?= $vehicule->marqueVehicule ?></span>
                            <span class="bg-slate-900 text-white px-3 py-1 rounded-full text-[10px] font-bold"><?= $vehicule->anneeVehicule ?></span>
                        </div>

                        <form id="favoriteForm" action="#" method="POST">
                            <input type="hidden" name="idVehicule" value="<?= $vehicule->idVehicule ?>">
                            <input type="hidden" name="page" value="accueil">
                            <input type="hidden" name="action" value="favorite">
                            <button onclick="toggleFavorite(this)" id="favoriteButton" type="button"
                                class=" favorite-btn absolute top-4 right-4 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 transition-all duration-300 shadow-lg group/heart">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>

                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800"><?= $vehicule->marqueVehicule . ' ' . $vehicule->modeleVehicule ?></h3>
                                <p class="text-slate-400 text-sm flex items-center gap-1 mt-1">
                                    <i class="fas fa-palette"></i> Midnight Black
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-blue-600"><?= $vehicule->prixVehicule  ?> </p>
                                <p class="text-xs text-slate-400 uppercase font-bold">MAD/Day</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-6 border-y border-slate-50 my-2">
                            <div class="flex items-center gap-3 text-slate-600">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-xs">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="text-sm font-medium"><?= $vehicule->typeBoiteVehicule ?></span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-600">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-xs">
                                    <i class="fas fa-gas-pump"></i>
                                </div>
                                <span class="text-sm font-medium"><?= $vehicule->typeCarburantVehicule ?></span>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 flex gap-3">
                            <a href="details.php?id=<?= $vehicule->idVehicule ?>" class="flex-1 text-center py-3.5 px-4 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                Details
                            </a>
                            <button class="flex-[1.5] text-center py-3.5 px-4 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <div class="mt-16 flex justify-center items-center gap-4">
            <button class="w-12 h-12 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-white hover:text-blue-600 transition">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="flex gap-2">
                <span class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold">1</span>
                <button class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 transition">2</button>
            </div>
            <button class="w-12 h-12 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-white hover:text-blue-600 transition">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </section>

    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-3xl font-black text-blue-500">MaBagnole</span>
            <p class="text-slate-500 text-sm mt-8">© 2025 MaBagnole Management. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/main.js"></script>
</body>

</html>