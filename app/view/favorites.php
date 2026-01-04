<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Vehicule;



session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'client') {
    header('Location: login.php');
    exit();
} else {

    $vehicule = new Vehicule();

    $vehicules = $vehicule->getVehiculesFavorisByClient($_SESSION['Utilisateur']->getIdUtilisateur());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | My Favorites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .is-favorite {
            color: #ef4444 !important;
        }

        .car-card:hover {
            transform: translateY(-8px);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    <nav class="flex justify-between items-center px-8 py-4 bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>
        <div class="hidden md:flex gap-8 items-center">
            <a href="accueil.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Browse Cars</a>
            <a href="my_reservations.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">My Bookings</a>
            <a href="favorites.php" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-1">Favorites</a>
        </div>
        <?php include('infoClient.php'); ?>
    </nav>

    <main class="max-w-7xl mx-auto px-8 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800">Saved Vehicles</h1>
                <p class="text-slate-500 mt-2">Your personal wishlist of premium rides.</p>
            </div>
            <div class="bg-blue-50 text-blue-600 px-4 py-2 rounded-2xl text-xs font-bold flex items-center gap-2">
                <i class="fas fa-heart"></i> <span id="fav-count"><?= count($vehicules) ?></span> Cars Saved
            </div>
        </div>

        <div id="favoritesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (!empty($vehicules)):  ?>
                <?php foreach ($vehicules as $vehicule) : ?>
                    <div class="car-card bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col transition-all duration-300 relative group">
                        <div class="relative overflow-hidden">
                            <img src="<?= $vehicule->getimageVehicule() ?>" class="w-full h-60 object-cover">
                            <form id="favoriteForm" action="#" method="POST">
                                <input type="hidden" name="idVehicule" value="<?= $vehicule->getIdVehicule() ?>">
                                <input type="hidden" name="page" value="accueil">
                                <input type="hidden" name="action" value="favorite">
                                <button onclick="removeFavorite(this, 101)" id="favoriteButton" type="button"
                                    class=" favorite-btn absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 shadow-lg hover:scale-110 transition active:scale-95">
                                    <i class="fas fa-heart text-lg"></i>
                                </button>

                            </form>
                        </div>

                        <div class="p-8 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-slate-800"><?= $vehicule->getMarqueVehicule() . ' ' . $vehicule->getModeleVehicule() ?></h3>
                                <p class="text-xl font-black text-blue-600">$299<span class="text-[10px] text-slate-400 font-bold uppercase ml-1">/Day</span></p>
                            </div>

                            <div class="flex gap-4 mb-6">
                                <span class="text-xs font-bold text-slate-500 flex items-center gap-1"><i class="fas fa-cog text-blue-500"></i> <?= $vehicule->getTypeBoiteVehicule() ?></span>
                                <span class="text-xs font-bold text-slate-500 flex items-center gap-1"><i class="fas fa-gas-pump text-blue-500"></i> <?= $vehicule->getTypeCarburantVehicule() ?></span>
                            </div>

                            <div class="mt-auto pt-6 border-t border-slate-50 flex gap-3">
                                <a href="./details.php?id=<?= $vehicule->getIdVehicule() ?>" class="flex-1 py-3 px-4 rounded-xl text-center font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>


            <?php endforeach;
            endif; ?>
        </div>


        <div id="emptyState" class="<?php echo (empty($vehicules)) ? 'flex' : 'hidden'; ?> flex-col items-center justify-center w-full gap-2 text-center py-20">
            <div class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">
                <i class="far fa-heart"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">No favorites yet</h2>
            <p class="text-slate-400 mt-1 mb-8 max-w-[250px] mx-auto">
                Start exploring and save cars you love!
            </p>
            <a href="accueil.php"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 hover:scale-105 transition-all duration-200 shadow-lg shadow-blue-200">
                Explore Fleet
            </a>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/main.js"></script>
    <script>
        function removeFavorite(button, carId) {
            const card = button.closest('.car-card');
            card.style.transform = "scale(0.9)";
            card.style.opacity = "0";

            setTimeout(() => {
                card.remove();

                const countElem = document.getElementById('fav-count');
                let count = parseInt(countElem.innerText);
                countElem.innerText = Math.max(0, count - 1);

                const grid = document.getElementById('favoritesGrid');
                if (grid.children.length === 0) {
                    document.getElementById('emptyState').classList.remove('hidden');
                }
            }, 300);

            console.log("Vehicle " + carId + " removed from favorites");


        }








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
    </script>
</body>

</html>