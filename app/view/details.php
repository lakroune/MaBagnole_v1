<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Vehicule;
use app\model\Avis;
use app\model\Reservation;

session_start();
$connect = true;
if (!isset($_SESSION['Utilisateur']) or  $_SESSION['Utilisateur']->getRole() !== 'client') {
    $connect =  false;
}
$v = new Vehicule();
if (!isset($_GET['id'])) {
    header('Location: accueil.php');
    exit();
}
$idVehicule = (int) $_GET['id'];
$vehicle = $v->getVehiculeById($idVehicule);

$avis = new Avis();
$reviews =     $avis->getAllAvisByVehicule($idVehicule);

if ($connect) {
    $reservation = new Reservation();
    $isReserver = $reservation->getReservationByClientVehicule($idClient = $_SESSION['Utilisateur']->getIdUtilisateur(), $idVehicule);
    $dejaCommente = $avis->checkAvis($idClient, $isReserver);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Vehicle Details & Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .star-active {
            color: #fbbf24;
        }

        /* Yellow-400 */
        .modal-active {
            display: flex !important;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans leading-normal tracking-normal">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="accueil.php" class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></a>
            <a href="accueil.php" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Fleet
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8">

            <div class="lg:w-2/3">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 mb-8">
                    <img src="<?= $vehicle->getImageVehicule() ?>"
                        alt="Car Display" class="w-full h-[450px] object-cover">
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-cog text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Transmission</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->getTypeBoiteVehicule() ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-gas-pump text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Fuel</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->getTypeCarburantVehicule() ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-calendar-check text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Year</p>
                        <p class="font-bold text-slate-800"><?= $vehicle->getAnneeVehicule()  ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-palette text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Color</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->getCouleurVehicule() ?></p>
                    </div>
                </div>

                <section class="bg-white rounded-3xl p-6 md:p-10 border border-slate-200 shadow-sm">
                    <h3 class="text-2xl font-bold text-slate-800 mb-8">Customer Feedback</h3>

                    <div id="reviews-list" class="space-y-8">
                        <?php if ($avis) : ?>
                            <?php foreach ($reviews as $review) : ?>
                                <div id="review-101" class="border-b border-slate-100 pb-8 last:border-0 group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">JD</div>
                                            <div>
                                                <h4 class="font-bold text-slate-800">John Doe</h4>
                                                <div class="flex text-yellow-400 text-[10px]">
                                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                                        <?php if ($i < $review->getNoteAvis()) : ?>

                                                            <i class="fas fa-star"></i>
                                                        <?php else: ?>
                                                            <i class="fas fa-star text-slate-200"></i>
                                                        <?php endif ?>
                                                    <?php endfor ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-4">
                                            <?php if ($connect and $_SESSION['Utilisateur']->getIdUtilisateur() == $review->getIdClient()) : ?>
                                                <button
                                                    onclick="openEditReviewModal(<?= $review->getIdAvis() ?>, '<?= addslashes($review->getCommentaireAvis()) ?>')"
                                                    class="text-xs font-bold text-blue-400 hover:text-blue-600 transition">
                                                    Edit
                                                </button> <button onclick="openDeleteReviewModal(<?= $review->getIdAvis() ?>)" class="text-xs font-bold text-red-400 hover:text-red-600 transition">
                                                    Delete
                                                </button>
                                            <?php endif ?>
                                        </div>
                                    </div>

                                    <p id="review-text-<?php echo $review->getIdAvis() ?>" class="mt-4 text-slate-600 italic leading-relaxed">
                                        <?php echo $review->getCommentaireAvis() ?>
                                    </p>

                                    <!-- <div class="mt-4 flex items-center gap-6">
                                        <button <?php if ($connect) : ?>onclick="handleReaction(101, 'like')" <?php endif ?> id="like-btn-101" class="flex items-center gap-2 text-slate-400 hover:text-blue-600 transition group">
                                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-blue-50">
                                                <i class="far fa-thumbs-up text-sm"></i>
                                            </div>
                                            <span id="like-count-101" class="text-xs font-bold">12</span>
                                        </button>

                                        <button <?php if ($connect) : ?>onclick="handleReaction(101, 'dislike')" <?php endif ?> id="dislike-btn-101" class="flex items-center gap-2 text-slate-400 hover:text-red-500 transition group">
                                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-red-50">
                                                <i class="far fa-thumbs-down text-sm"></i>
                                            </div>
                                            <span id="dislike-count-101" class="text-xs font-bold">2</span>
                                        </button>
                                    </div> -->
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>

                    </div>
                    <?php if ($connect and $isReserver and !$dejaCommente) : ?>
                        <div class="mt-12 pt-8 border-t border-slate-100">
                            <h4 class="font-bold text-lg text-slate-800 mb-4">Leave an Evaluation</h4>
                            <form action="../controler/ClientControler.php" method="POST" id="form-ajout-avis">
                                <div class="flex gap-2 mb-4" id="star-selector">
                                    <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="1"></i>
                                    <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="2"></i>
                                    <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="3"></i>
                                    <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="4"></i>
                                    <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="5"></i>
                                </div>
                                <input type="hidden" name="ratings" id="rating">
                                <input type="hidden" name="page" value="details">
                                <input type="hidden" name="action" value="addReview">
                                <input type="hidden" name="idVehicule" value="<?= $idVehicule ?>">
                                <input type="hidden" name="idReservation" value="<?= $isReserver ?>">
                                <textarea name="textReview" id="new-review-text" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition" rows="3" placeholder="Share your experience..."></textarea>
                                <button type="button" id="btn-ajout-avis" onclick="submitReview()" class=" btn-ajout-avis  mt-4 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">Post Review</button>

                            </form>
                        </div>
                    <?php endif; ?>
                </section>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl sticky top-24">
                    <div class="mb-6">
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-widest">Premium Selection</span>
                        <h2 class="text-3xl font-black text-slate-800 mt-1"><?= $vehicle->getMarqueVehicule() . ' ' . $vehicle->getModeleVehicule() ?></h2>
                    </div>

                    <input type="hidden" id="base-price" value="<?php echo $vehicle->getPrixVehicule(); ?>">

                    <div class="flex items-baseline gap-1 mb-6">
                        <span id="total-display" class="text-5xl font-black text-slate-900"><?= $vehicle->getPrixVehicule(); ?></span>
                        <span class="text-slate-400 font-medium">MAD/ total</span>
                    </div>

                    <form action="../controler/ClientControler.php" method="POST" class="space-y-4">
                        <input type="hidden" name="idVehicule" value="<?php echo $vehicle->getIdVehicule(); ?>">
                        <input type="hidden" id="dureeReservation" name="dureeReservation" value="1">
                        <input type="hidden" name="page" value="details">
                        <input type="hidden" name="action" value="rent">

                        <div>
                            <label class="block text-[11px] font-black uppercase text-slate-400 mb-2">Pick-up location</label>
                            <div class="relative">
                                <select name="lieuChange" required
                                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border <?php if (!$connect)  echo "cursor-not-allowed "; ?>  border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer">
                                    <option value="">select location</option>
                                    <option value="casablanca_airport">Casablanca Mohammed V International Airport (CMN)</option>
                                    <option value="marrakech_airport">Marrakech Menara Airport (RAK)</option>
                                    <option value="agadir_airport">Agadir Al Massira Airport (AGA)</option>
                                    <option value="tangier_airport">Tangier Ibn Battouta Airport (TNG)</option>
                                    <option value="fes_airport">Fes Sais Airport (FEZ)</option>
                                    <option value="rabat_airport">Rabat-Salé Airport (RBA)</option>
                                    <option value="nador_airport">Nador International Airport (NDR)</option>
                                    <option value="oujda_airport">Oujda Angads Airport (OUD)</option>

                                    <option value="casablanca_downtown">Casablanca City Center</option>
                                    <option value="casablanca_voyageurs_station">Casablanca Voyageurs Train Station</option>
                                    <option value="marrakech_downtown">Marrakech City Center (Gueliz)</option>
                                    <option value="marrakech_train_station">Marrakech Train Station</option>
                                    <option value="rabat_city_center">Rabat City Center</option>
                                    <option value="rabat_agdal_station">Rabat Agdal Train Station</option>
                                    <option value="tangier_city_center">Tangier City Center</option>
                                    <option value="tangier_port">Tangier Med Port</option>
                                    <option value="agadir_beach_center">Agadir City Center & Beach</option>
                                    <option value="essaouira_downtown">Essaouira City Center</option>
                                    <option value="chefchaouen_center">Chefchaouen City Center</option>
                                    <option value="ouarzazate_center">Ouarzazate City Center</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                    <i class="fas fa-map-marker-alt text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-400 mb-2">Date Début</label>
                                <input type="date" id="dateDebut" name="dateDebutReservation" value="<?php echo date('Y-m-d'); ?>" <?php if (!$connect)  echo "readonly "; ?>required required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500 <?php if (!$connect)  echo "cursor-not-allowed "; ?> ">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-400 mb-2">Date Fin</label>
                                <input type="date" id="dateFin" name="dateFinReservation" value="<?php echo date('Y-m-d'); ?>" <?php if (!$connect)  echo "readonly "; ?>required
                                    class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500 <?php if (!$connect)  echo "cursor-not-allowed "; ?> ">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 mt-2">
                            <label class="block text-[11px] font-black uppercase text-slate-400 mb-2">Option Supplémentaire</label>
                            <div class="relative">
                                <select id="optionSelect" name="idOption" <?php if (!$connect)  echo "desabled "; ?>
                                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer">
                                    <option value="0" data-price="0">No Extra Options</option>
                                    <option value="1" data-price="150">GPS Navigation (+150 MAD)</option>
                                    <option value="2" data-price="250">Multimedia Pack (+250 MAD)</option>
                                    <option value="3" data-price="100">Child Safety Seat (+100 MAD)</option>

                                    <option value="4" data-price="200">Additional Driver (+200 MAD)</option>
                                    <option value="5" data-price="300">Full Insurance (Zero Deductible) (+300 MAD)</option>
                                    <option value="6" data-price="50">USB Charger & Phone Holder (+50 MAD)</option>
                                    <option value="7" data-price="400">Roof Rack / Luggage Carrier (+400 MAD)</option>
                                    <option value="8" data-price="150">Wi-Fi Hotspot (4G/5G) (+150 MAD)</option>
                                    <option value="9" data-price="80">Booster Seat (for older children) (+80 MAD)</option>
                                    <option value="10" data-price="500">Snow Chains (for mountain trips) (+500 MAD)</option>
                                    <option value="11" data-price="120">Baby Stroller (+120 MAD)</option>
                                    <option value="12" data-price="0">Full Tank of Fuel (Pay at return)</option>
                                    <option value="13" data-price="250">Roadside Assistance 24/7 (+250 MAD)</option>
                                    <option value="14" data-price="150">Airport Meet & Greet Service (+150 MAD)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                    <i class="fas fa-plus-circle text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" <?php if (!$connect)  echo "disabled "; ?> class="w-full <?php if (!$connect)  echo "cursor-not-allowed  "; ?>  bg-slate-900 text-white py-4 rounded-2xl font-bold text-lg hover:bg-blue-600 transition shadow-lg mt-6">
                            Confirmer la Réservation
                        </button>
                        <?php if (!$connect): ?>
                            <div class="bg-red-100 border border-red-100 text-red-400 px-4 py-3 rounded relative mt-6" role="alert">
                                <span class="block sm:inline">You must be logged in to make a reservation.
                                    <a href="login.php" class="absolute top-2 right-2 text-red-900">Sign In</a>
                                </span>

                            </div>
                        <?php endif; ?>
                    </form>
                </div>


            </div>
        </div>
    </main>
    <div id="deleteReviewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[120] p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl text-center relative animate-fade-in">

            <button onclick="toggleModal('deleteReviewModal')" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600 transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Delete Review?</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                Are you sure you want to delete this feedback? This action cannot be undone and the review will be permanently removed.
            </p>

            <form action="../controler/ClientControler.php" method="POST">
                <input type="hidden" name="page" value="details">
                <input type="hidden" name="action" value="deleteReview">
                <input type="hidden" name="idAvis" id="delete_avis_id">
                <input type="hidden" name="idVehicule" value="<?= $idVehicule ?>">

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-red-700 transition active:scale-95">
                        Yes, Delete Permanently
                    </button>
                    <button type="button" onclick="toggleModal('deleteReviewModal')" class="w-full bg-slate-100 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-200 transition">
                        No, Keep it
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editReviewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[120] p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl relative animate-fade-in">

            <button onclick="toggleModal('editReviewModal')" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600 transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800">Edit Your Review</h3>
                <p class="text-slate-500 text-sm">Update your feedback about this vehicle.</p>
            </div>

            <form action="../controler/ClientControler.php" method="POST">
                <input type="hidden" name="page" value="details">
                <input type="hidden" name="action" value="updateReview">
                <input type="hidden" name="idAvis" id="edit_avis_id">
                <input type="hidden" name="idVehicule" value="<?= $idVehicule ?>">

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Your Message</label>
                    <textarea
                        name="textReview"
                        id="edit_comment_text"
                        rows="4"
                        class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-blue-500 focus:ring-0 transition resize-none text-slate-600"
                        placeholder="Write your thoughts here..."
                        required></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="toggleModal('editReviewModal')" class="flex-1 bg-slate-100 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-200 transition">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-blue-700 transition active:scale-95">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="errorModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative animate-bounce-short">
            <button onclick="closeError()" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>

            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-exclamation-circle"></i>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Error</h3>
            <p id="errorMessage" class="text-slate-500 text-sm mb-8 leading-relaxed">
                yor reservation failed please try again .
            </p>

            <div class="flex flex-col gap-3">
                <button onclick="closeError()" class="w-full bg-slate-50 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-100 transition">try again</button>

                <a href="accueil.php" class="text-sm font-bold text-blue-600 hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i>back to fleet</a>
            </div>
        </div>
    </div>
    <div id="successModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative animate-fade-in">

            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-check-circle"></i>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Success!</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                your reservation has been made successfully
            </p>

            <div class="flex flex-col gap-3">

                <a href="accueil.php" class=" feedback w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-slate-800 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Fleet
                </a>
            </div>
        </div>
    </div>


    <div id="reviewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[110] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative">

            <div id="reviewIconBox" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i id="reviewIcon" class="fas"></i>
            </div>

            <h3 id="reviewTitle" class="text-2xl font-black text-slate-800 mb-2"></h3>
            <p id="reviewMessage" class="text-slate-500 text-sm mb-8 leading-relaxed"></p>

            <button onclick="closeReviewModal()" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-slate-800 transition">
                Continue
            </button>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function submitReview() {
            const text = document.getElementById('new-review-text').value;

            // Validation Check
            if (!text || selectedRating == 0 || !text.trim() || selectedRating == 0) {
                return showReviewPopup('error', 'Incomplete', 'Please provide both a rating and a comment before submitting.');
            } else {
                document.getElementById('form-ajout-avis').submit();
            }


        }

        function openEditReviewModal(idAvis, currentComment) {
            // Remplir l'ID caché
            document.getElementById('edit_avis_id').value = idAvis;
            // Remplir le textarea avec le texte actuel
            document.getElementById('edit_comment_text').value = currentComment;
            // Afficher le modal
            toggleModal('editReviewModal');
        }



        // Auto-trigger based on URL Parameters
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            // Handle Success
            if (urlParams.has('rent') && urlParams.get('rent') === "success") {
                showModal('successModal');
            }


            // Handle Errors
            if (urlParams.has('rent') && urlParams.get('rent') === "failed") {
                const errorType = urlParams.get('reservation');
                const errorText = document.getElementById('errorMessage');

                if (errorType === "failed") {
                    errorText.innerText = "Please fill all fields correctly and try again .";
                }

                showModal('errorModal');
            }

            if (urlParams.has('addReview') && urlParams.get('addReview') === "success") {
                showReviewPopup('success', 'Thank You!', 'Your review has been submitted successfully and is waiting for admin approval.');

            }
            if (urlParams.has('addReview') && urlParams.get('addReview') === "failed") {
                showReviewPopup('error', 'Error', 'An error occurred while submitting your review.');

            }
            if (urlParams.has('deleteReview') && urlParams.get('deleteReview') === "success") {
                showReviewPopup('success', 'Success', 'Your review has been deleted successfully.');
            }
            if (urlParams.has('deleteReview') && urlParams.get('deleteReview') === "failed") {
                showReviewPopup('error', 'Error', 'An error occurred while deleting your review.');
            }
            if (urlParams.has('updateReview') && urlParams.get('updateReview') === "success") {
                showReviewPopup('success', 'Success', 'Your review has been updated successfully.');
            }
            if (urlParams.has('updateReview') && urlParams.get('updateReview') === "failed") {
                showReviewPopup('error', 'Error', 'An error occurred while updating your review.');
            }

        };


        const basePrice = parseFloat(document.getElementById('base-price').value);
        const dateDebut = document.getElementById('dateDebut');
        const dateFin = document.getElementById('dateFin');
        const optionSelect = document.getElementById('optionSelect');
        const totalDisplay = document.getElementById('total-display');
        const dureeInput = document.getElementById('dureeReservation');



        dateDebut.addEventListener('change', calculateTotal);
        dateFin.addEventListener('change', calculateTotal);
        optionSelect.addEventListener('change', calculateTotal);

        // --- Star Selection Logic ---
        const stars = document.querySelectorAll('#star-selector i');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('click', () => {
                selectedRating = star.getAttribute('data-value');
                document.getElementById('rating').value = selectedRating;
                updateStars(selectedRating);
            });
        });
    </script>
</body>

</html>