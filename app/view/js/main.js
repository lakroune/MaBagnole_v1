//  --app / view / js / main.js-- 
// Toggle favorite 
function toggleFavorite(button) {
    button.classList.toggle('is-favorite');
}



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

function openDeleteReviewModal(idAvis) {
    const input = document.getElementById('delete_avis_id');
    if (input) {
        input.value = idAvis;
        toggleModal('deleteReviewModal');
    }
}
// --- Soft Delete ---
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
    // In real app: Send fetch() request to PHP backend to save changes
}
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
function showModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeError() {
    document.getElementById('errorModal').classList.add('hidden');
}
function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewModal').classList.remove('flex');
}

function showReviewPopup(type, title, message) {
    const modal = document.getElementById('reviewModal');
    const iconBox = document.getElementById('reviewIconBox');
    const icon = document.getElementById('reviewIcon');
    const titleEl = document.getElementById('reviewTitle');
    const messageEl = document.getElementById('reviewMessage');

    if (type === 'success') {
        iconBox.className = "w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl";
        icon.className = "fas fa-check-circle";
    } else {
        iconBox.className = "w-20 h-20 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl";
        icon.className = "fas fa-exclamation-triangle";
    }

    titleEl.innerText = title;
    messageEl.innerText = message;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function showStatusModal(type, title, message) {
    const modal = document.getElementById('statusModal');
    const iconContainer = document.getElementById('statusIconContainer');
    const icon = document.getElementById('statusIcon');
    const titleEl = document.getElementById('statusTitle');
    const messageEl = document.getElementById('statusMessage');
    const btn = document.getElementById('statusBtn');

    if (type === 'success') {
        iconContainer.className = "w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl border-4 border-white shadow-sm";
        icon.className = "fas fa-check-circle";
        btn.className = "w-full bg-green-500 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-green-600 transition active:scale-95";
    } else {
        iconContainer.className = "w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl border-4 border-white shadow-sm";
        icon.className = "fas fa-exclamation-circle";
        btn.className = "w-full bg-red-500 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-red-600 transition active:scale-95";
    }

    titleEl.innerText = title;
    messageEl.innerText = message;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    // Optional: Clean URL after closing
    window.history.replaceState({}, document.title, window.location.pathname);
}


function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}



function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}

function openEditModal(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_marque').value = data.marque;
    document.getElementById('edit_modele').value = data.modele;
    document.getElementById('edit_annee').value = data.annee;
    document.getElementById('edit_couleur').value = data.couleur;
    document.getElementById('edit_boite').value = data.boite;
    document.getElementById('edit_carburant').value = data.carburant;
    document.getElementById('edit_prix').value = data.prix;
    document.getElementById('edit_cat').value = data.cat;
    document.getElementById('edit_image').value = data.img;
    toggleModal('editVehicleModal');
}

function openDeleteModal(data) {
    document.getElementById('delete_id').value = data.id;
    toggleModal('deleteModal');
}

