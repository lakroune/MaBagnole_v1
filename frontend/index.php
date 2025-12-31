<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Location de Voiture Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans text-slate-900">

    <nav class="flex justify-between items-center px-8 py-6 fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="text-2xl font-black text-blue-600">Ma<span class="text-slate-800">Bagnole</span></div>
        <div class="flex gap-6 items-center">
            <a href="#stats" class="text-sm font-bold text-slate-600 hover:text-blue-600">Pourquoi nous?</a>
            <a href="login.php" class="text-sm font-bold text-slate-800">Connexion</a>
            <a href="register" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">S'inscrire</a>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-8 flex flex-col md:flex-row items-center gap-12 max-w-7xl mx-auto">
        <div class="flex-1 space-y-8">
            <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">Premium Rental Service</span>
            <h1 class="text-6xl font-black leading-tight">Roulez avec <br><span class="text-blue-600">Style et Confort</span></h1>
            <p class="text-slate-500 text-lg leading-relaxed max-w-md">Découvrez notre flotte exclusive de véhicules pour vos voyages d'affaires ou vos escapades en famille.</p>
            <div class="flex gap-4">
                <a href="catalogue.php" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-600 transition flex items-center gap-2">
                    Explorer la flotte <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800" alt="Porsche" class="rounded-[40px] shadow-2xl">
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-xl flex items-center gap-4 border border-slate-100">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase">Disponibilité</p>
                    <p class="font-black text-slate-800">24/7 Service Client</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="bg-slate-900 py-20">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
            <div class="space-y-2">
                <h3 class="text-5xl font-black text-blue-500">500+</h3>
                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Véhicules</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-5xl font-black text-blue-500">12k</h3>
                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Clients Heureux</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-5xl font-black text-blue-500">15</h3>
                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Villes au Maroc</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-5xl font-black text-blue-500">4.9/5</h3>
                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Note Moyenne</p>
            </div>
        </div>
    </section>

    <section class="py-24 px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">Pourquoi choisir MaBagnole?</h2>
            <div class="w-20 h-2 bg-blue-600 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:border-blue-500 transition-all group">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="text-xl font-black mb-4">Assurance Complète</h4>
                <p class="text-slate-500 leading-relaxed">Partez l'esprit tranquille, tous nos véhicules sont assurés tous risques.</p>
            </div>
            <div class="p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:border-blue-500 transition-all group">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition">
                    <i class="fas fa-bolt"></i>
                </div>
                <h4 class="text-xl font-black mb-4">Réservation Instantanée</h4>
                <p class="text-slate-500 leading-relaxed">Réservez votre voiture en moins de 2 minutes via notre plateforme sécurisée.</p>
            </div>
            <div class="p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:border-blue-500 transition-all group">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition">
                    <i class="fas fa-headset"></i>
                </div>
                <h4 class="text-xl font-black mb-4">Support 24/7</h4>
                <p class="text-slate-500 leading-relaxed">Une question ? Notre équipe est disponible jour et nuit pour vous assister.</p>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-slate-100 text-center">
        <p class="text-slate-400 text-sm font-medium">© 2025 MaBagnole - Leader de la location au Maroc.</p>
    </footer>

</body>
</html>