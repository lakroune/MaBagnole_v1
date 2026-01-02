<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Vehicule;

session_start();
$connect = true;
if (!isset($_SESSION['Utilisateur']) or  $_SESSION['Utilisateur']->role !== 'client') {
    $connect =  false;
}
$v = new Vehicule();
$idVehicule = (int) $_GET['id'];
$vehicle = $v->getVehiculeById($idVehicule);



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
                    <img src="<?= $vehicle->imageVehicule ?>"
                        alt="Car Display" class="w-full h-[450px] object-cover">
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-cog text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Transmission</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->typeBoiteVehicule ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-gas-pump text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Fuel</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->typeCarburantVehicule ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-calendar-check text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Year</p>
                        <p class="font-bold text-slate-800"><?= $vehicle->anneeVehicule  ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                        <i class="fas fa-palette text-blue-600 mb-2"></i>
                        <p class="text-[10px] uppercase font-bold text-slate-400">Color</p>
                        <p class="font-bold text-slate-800"><?php echo $vehicle->couleurVehicule ?></p>
                    </div>
                </div>

                <section class="bg-white rounded-3xl p-6 md:p-10 border border-slate-200 shadow-sm">
                    <h3 class="text-2xl font-bold text-slate-800 mb-8">Customer Feedback</h3>

                    <div id="reviews-list" class="space-y-8">
                        <div id="review-101" class="border-b border-slate-100 pb-8 last:border-0 group">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">JD</div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">John Doe</h4>
                                        <div class="flex text-yellow-400 text-[10px]">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star text-slate-200"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <?php if ($connect and $_SESSION['Utilisateur']->role === 'client') : ?>
                                        <button onclick="toggleEdit(101)" class="text-xs font-bold text-blue-500 hover:text-blue-700 transition">Edit</button>
                                        <button onclick="softDelete(101)" class="text-xs font-bold text-red-400 hover:text-red-600 transition">Delete</button>
                                    <?php endif ?>
                                </div>
                            </div>

                            <p id="review-text-101" class="mt-4 text-slate-600 italic leading-relaxed">
                                "The car was in perfect condition and the pickup process was very smooth!"
                            </p>

                            <div class="mt-4 flex items-center gap-6">
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
                            </div>
                        </div>


                    </div>
                    <?php if ($connect) : ?>
                        <div class="mt-12 pt-8 border-t border-slate-100">
                            <h4 class="font-bold text-lg text-slate-800 mb-4">Leave an Evaluation</h4>
                            <div class="flex gap-2 mb-4" id="star-selector">
                                <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="1"></i>
                                <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="2"></i>
                                <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="3"></i>
                                <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="4"></i>
                                <i class="fas fa-star cursor-pointer text-slate-200 text-xl hover:text-yellow-400" data-value="5"></i>
                            </div>
                            <textarea id="new-review-text" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition" rows="3" placeholder="Share your experience..."></textarea>
                            <button onclick="submitReview()" class="mt-4 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">Post Review</button>
                        </div>
                    <?php endif; ?>
                </section>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl sticky top-24">
                    <div class="mb-6">
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-widest">Premium Selection</span>
                        <h2 class="text-3xl font-black text-slate-800 mt-1"><?= $vehicle->marqueVehicule . ' ' . $vehicle->modeleVehicule ?></h2>
                    </div>

                    <input type="hidden" id="base-price" value="<?php echo $vehicle->prixVehicule; ?>">

                    <div class="flex items-baseline gap-1 mb-6">
                        <span id="total-display" class="text-5xl font-black text-slate-900"><?= $vehicle->prixVehicule ?></span>
                        <span class="text-slate-400 font-medium">MAD/ total</span>
                    </div>

                    <form action="../controler/ClientControler.php" method="POST" class="space-y-4">
                        <input type="hidden" name="idVehicule" value="<?php echo $vehicle->idVehicule; ?>">
                        <input type="hidden" id="dureeReservation" name="dureeReservation" value="1">
                        <input type="hidden" name="page" value="details">



                        <div>
                            <label class="block text-[11px] font-black uppercase text-slate-400 mb-2">Lieu de prise en charge (lieuChange)</label>
                            <div class="relative">
                                <select name="lieuChange" required
                                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border <?php if (!$connect)  echo "cursor-not-allowed "; ?>  border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer">
                                    <option value="">Sélectionnez un lieu</option>
                                    <option value="Casablanca Airport">Aéroport Mohammed V (CMN)</option>
                                    <option value="Marrakech Airport">Aéroport Marrakech-Ménara (RAK)</option>
                                    <option value="Agadir Airport">Aéroport Agadir-Al Massira (AGA)</option>
                                    <option value="Tangier Airport">Aéroport Ibn Battouta (TNG)</option>
                                    <option value="Rabat City Center">Rabat Centre-Ville</option>
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
                                    <option value="0" data-price="0">Aucune Option</option>
                                    <option value="1" data-price="15">GPS Navigation (+$15)</option>
                                    <option value="2" data-price="25">Pack Multimédia (+$25)</option>
                                    <option value="3" data-price="10">Siège Enfant (+$10)</option>
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

    <div id="edit-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Update your Feedback</h3>
            <input type="hidden" id="edit-id">
            <textarea id="edit-text" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500" rows="5"></textarea>
            <div class="flex justify-end gap-3 mt-6">
                <button onclick="closeEdit()" class="px-6 py-2 font-bold text-slate-400">Cancel</button>
                <button onclick="saveEdit()" class="px-8 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Save</button>
            </div>
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

    <script>
        function showModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeError() {
            document.getElementById('errorModal').classList.add('hidden');
        }

        // Auto-trigger based on URL Parameters
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            // Handle Success
            if (urlParams.has('reservation') && urlParams.get('reservation') === "success") {
                showModal('successModal');
            }

            // Handle Errors
            if (urlParams.has('reservation') && urlParams.get('reservation') === "failed") {
                const errorType = urlParams.get('reservation');
                const errorText = document.getElementById('errorMessage');

                if (errorType === "failed") {
                    errorText.innerText = "Please fill all fields correctly and try again .";
                }

                showModal('errorModal');
            }
        };
    </script>

    <script>
        function handleReaction(reviewId, type) {
            const likeBtn = document.querySelector(`#like-btn-${reviewId} i`);
            const dislikeBtn = document.querySelector(`#dislike-btn-${reviewId} i`);
            const likeCount = document.getElementById(`like-count-${reviewId}`);
            const dislikeCount = document.getElementById(`dislike-count-${reviewId}`);

            if (type === 'like') {
                // Toggle Like
                if (likeBtn.classList.contains('far')) {
                    likeBtn.classList.replace('far', 'fas');
                    likeBtn.parentElement.classList.add('bg-blue-100', 'text-blue-600');
                    likeCount.innerText = parseInt(likeCount.innerText) + 1;

                    // Remove dislike if active
                    if (dislikeBtn.classList.contains('fas')) {
                        dislikeBtn.classList.replace('fas', 'far');
                        dislikeBtn.parentElement.classList.remove('bg-red-100', 'text-red-500');
                        dislikeCount.innerText = parseInt(dislikeCount.innerText) - 1;
                    }
                } else {
                    likeBtn.classList.replace('fas', 'far');
                    likeBtn.parentElement.classList.remove('bg-blue-100', 'text-blue-600');
                    likeCount.innerText = parseInt(likeCount.innerText) - 1;
                }
            } else {
                // Toggle Dislike
                if (dislikeBtn.classList.contains('far')) {
                    dislikeBtn.classList.replace('far', 'fas');
                    dislikeBtn.parentElement.classList.add('bg-red-100', 'text-red-500');
                    dislikeCount.innerText = parseInt(dislikeCount.innerText) + 1;

                    // Remove like if active
                    if (likeBtn.classList.contains('fas')) {
                        likeBtn.classList.replace('fas', 'far');
                        likeBtn.parentElement.classList.remove('bg-blue-100', 'text-blue-600');
                        likeCount.innerText = parseInt(likeCount.innerText) - 1;
                    }
                } else {
                    dislikeBtn.classList.replace('fas', 'far');
                    dislikeBtn.parentElement.classList.remove('bg-red-100', 'text-red-500');
                    dislikeCount.innerText = parseInt(dislikeCount.innerText) - 1;
                }
            }

            // Console log for your PHP logic tracking
            console.log(`Review ${reviewId} reaction: ${type}`);
        }
    </script>
    <script>
        const basePrice = parseFloat(document.getElementById('base-price').value);
        const dateDebut = document.getElementById('dateDebut');
        const dateFin = document.getElementById('dateFin');
        const optionSelect = document.getElementById('optionSelect');
        const totalDisplay = document.getElementById('total-display');
        const dureeInput = document.getElementById('dureeReservation');

        function calculateTotal() {
            let days = 1;

            if (dateDebut.value && dateFin.value) {
                const start = new Date(dateDebut.value);
                const end = new Date(dateFin.value);
                const diffTime = end - start;
                days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (days <= 0) days = 1;
            }

            dureeInput.value = days;

            const selectedOption = optionSelect.options[optionSelect.selectedIndex];
            const optionPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;

            // Total = (Base Price * Number of Days) + Fixed Option Price
            const finalTotal = (basePrice * days) + optionPrice;

            totalDisplay.innerText = `$${finalTotal}`;
        }

        dateDebut.addEventListener('change', calculateTotal);
        dateFin.addEventListener('change', calculateTotal);
        optionSelect.addEventListener('change', calculateTotal);
    </script>
    <script>
        // --- Star Selection Logic ---
        const stars = document.querySelectorAll('#star-selector i');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('click', () => {
                selectedRating = star.getAttribute('data-value');
                updateStars(selectedRating);
            });
        });

        function updateStars(rating) {
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.add('star-active', 'fas');
                    s.classList.remove('text-slate-200', 'far');
                } else {
                    s.classList.remove('star-active', 'fas');
                    s.classList.add('text-slate-200', 'far');
                }
            });
        }

        // --- Soft Delete Logic (User Story 9) ---
        function softDelete(id) {
            if (confirm("Do you really want to remove this review?")) {
                const item = document.getElementById(`review-${id}`);
                item.style.transition = "all 0.5s ease";
                item.style.opacity = "0";
                setTimeout(() => {
                    item.classList.add('hidden'); // Simulated Soft Delete (hidden from user)
                    alert("Review deleted successfully.");
                }, 500);
            }
        }

        // --- Edit Logic ---
        function toggleEdit(id) {
            const currentText = document.getElementById(`review-text-${id}`).innerText.replace(/"/g, '');
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-text').value = currentText;
            document.getElementById('edit-modal').classList.add('modal-active');
        }

        function closeEdit() {
            document.getElementById('edit-modal').classList.remove('modal-active');
        }

        function saveEdit() {
            const id = document.getElementById('edit-id').value;
            const text = document.getElementById('edit-text').value;

            // UI Update
            document.getElementById(`review-text-${id}`).innerText = `"${text}"`;
            closeEdit();
            // In real app: Send fetch() request to PHP controller
        }

        function submitReview() {
            const text = document.getElementById('new-review-text').value;
            if (!text || selectedRating == 0) return alert("Please provide a rating and a comment.");
            alert("Thank you! Your review has been submitted for approval.");
            document.getElementById('new-review-text').value = "";
            updateStars(0);
        }
    </script>
</body>

</html>