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
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800">Welcome, Ahmed</p>
                <a href="logout.php" class="text-[10px] text-red-500 font-black uppercase tracking-widest hover:underline">Logout</a>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm">A</div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-8 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800">Saved Vehicles</h1>
                <p class="text-slate-500 mt-2">Your personal wishlist of premium rides.</p>
            </div>
            <div class="bg-blue-50 text-blue-600 px-4 py-2 rounded-2xl text-xs font-bold flex items-center gap-2">
                <i class="fas fa-heart"></i> <span id="fav-count">2</span> Cars Saved
            </div>
        </div>

        <div id="favoritesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            <div class="car-card bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col transition-all duration-300 relative group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800" class="w-full h-60 object-cover">

                    <button onclick="removeFavorite(this, 101)"
                        class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 shadow-lg hover:scale-110 transition active:scale-95">
                        <i class="fas fa-heart text-lg"></i>
                    </button>
                </div>

                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-slate-800">Porsche 911 Carrera</h3>
                        <p class="text-xl font-black text-blue-600">$299<span class="text-[10px] text-slate-400 font-bold uppercase ml-1">/Day</span></p>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <span class="text-xs font-bold text-slate-500 flex items-center gap-1"><i class="fas fa-cog text-blue-500"></i> Auto</span>
                        <span class="text-xs font-bold text-slate-500 flex items-center gap-1"><i class="fas fa-gas-pump text-blue-500"></i> Essence</span>
                    </div>

                    <div class="mt-auto pt-6 border-t border-slate-50 flex gap-3">
                        <button class="flex-1 py-3 px-4 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="car-card bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col transition-all duration-300 relative group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1542362567-b055002b91f4?w=800" class="w-full h-60 object-cover">
                    <button onclick="removeFavorite(this, 102)" class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 shadow-lg hover:scale-110 transition active:scale-95">
                        <i class="fas fa-heart text-lg"></i>
                    </button>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-slate-800">BMW M8 Coupe</h3>
                        <p class="text-xl font-black text-blue-600">$350<span class="text-[10px] text-slate-400 font-bold uppercase ml-1">/Day</span></p>
                    </div>
                    <div class="flex gap-4 mb-6 text-xs font-bold text-slate-500">
                        <span><i class="fas fa-cog text-blue-500 mr-1"></i> Auto</span>
                        <span><i class="fas fa-gas-pump text-blue-500 mr-1"></i> Essence</span>
                    </div>
                    <div class="mt-auto pt-6 border-t border-slate-50 flex gap-3">
                        <button class="flex-1 py-3 px-4 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div id="emptyState" class="hidden text-center py-20">
            <div class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                <i class="far fa-heart"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">No favorites yet</h2>
            <p class="text-slate-400 mt-2 mb-8">Start exploring and save cars you love!</p>
            <a href="accueil.php" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">Explore Fleet</a>
        </div>
    </main>

    <script>
        function removeFavorite(button, carId) {
            // Animation of card disappearing
            const card = button.closest('.car-card');
            card.style.transform = "scale(0.9)";
            card.style.opacity = "0";

            setTimeout(() => {
                card.remove();

                // Update counter
                const countElem = document.getElementById('fav-count');
                let count = parseInt(countElem.innerText);
                countElem.innerText = Math.max(0, count - 1);

                // Show empty state if no cars left
                const grid = document.getElementById('favoritesGrid');
                if (grid.children.length === 0) {
                    document.getElementById('emptyState').classList.remove('hidden');
                }
            }, 300);

            // Optional: Add AJAX call here to update the DB
            console.log("Vehicle " + carId + " removed from favorites");
        }
    </script>
</body>

</html>