<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        @keyframes bounce-short {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce-short {
            animation: bounce-short 0.5s ease-out;
        }
    </style>

</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-6xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row shadow-blue-100/50">

        <div class="md:w-5/12 bg-blue-600 relative p-12 flex flex-col justify-between overflow-hidden">
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <a href="index.php"> <span class="text-2xl font-black text-white">Ma<span class="text-slate-900">Bagnole</span></span>
                </a>
            </div>

            <div class="relative z-10 text-white">
                <h2 class="text-4xl font-black leading-tight mb-6">Join the <br>Elite Fleet.</h2>
                <p class="text-blue-100 text-sm mb-8">Register now to access premium vehicles and manage your bookings easily.</p>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-xs"><i class="fas fa-shield-alt"></i></div>
                        <span class="text-xs font-bold uppercase tracking-widest">Secure Registration</span>
                    </div>
                </div>
            </div>

            <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&q=80&w=800"
                class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-multiply">
        </div>

        <div class="md:w-7/12 p-8 md:p-12">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-800 mb-2">Create Account</h1>
                <p class="text-slate-400 font-medium text-sm">Fill in your information to get started.</p>
            </div>

            <form action="../controler/ClientControler.php" method="POST" class="space-y-5">

                <input type="hidden" name="page" value="register">


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">First Name</label>
                        <input type="text" name="prenomUtilisateur" required
                            placeholder="Ahmed"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Last Name</label>
                        <input type="text" name="nomUtilisateur" required
                            placeholder="Berrada"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Phone Number</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="tel" name="telephone" required
                                placeholder="0612345678"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">City</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                            <input type="text" name="ville" required
                                placeholder="Casablanca"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                        <input type="email" name="email" required
                            placeholder="ahmed@example.com"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                        <input type="password" name="paword" required
                            placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 text-white py-4 rounded-xl font-black shadow-xl hover:bg-slate-800 hover:-translate-y-0.5 transition-all mt-4">
                    Create My Account
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-50 pt-6">
                <p class="text-sm text-slate-400 font-medium">
                    Already a member?
                    <a href="login.php" class="text-blue-600 font-black hover:underline">Sign In</a>
                </p>
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

            <h3 class="text-2xl font-black text-slate-800 mb-2">Registration Failed</h3>
            <p id="errorMessage" class="text-slate-500 text-sm mb-8 leading-relaxed">
                This email address is already registered. Please try another one or sign in.
            </p>

            <div class="flex flex-col gap-3">
                <button onclick="closeError()" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-slate-800 transition">
                    Try Again
                </button>
                <a href="login.php" class="text-sm font-bold text-blue-600 hover:underline">Go to Login</a>
            </div>
        </div>
    </div>
    <div id="successModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative animate-fade-in">

            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fas fa-check-circle"></i>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Account Created!</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                Welcome to the **MaBagnole** family. Your premium journey starts right now.
            </p>

            <div class="flex flex-col gap-3">
                <a href="login.php" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                    Sign In Now <i class="fas fa-arrow-right ml-2"></i>
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
            if (urlParams.has('register') && urlParams.get('register') === "success") {
                showModal('successModal');
            }

            // Handle Errors
            if (urlParams.has('register')) {
                const errorType = urlParams.get('register');
                const errorText = document.getElementById('errorMessage');

                if (errorType === "failed") {
                    errorText.innerText = "Please fill all fields correctly and try again .";
                }

                showModal('errorModal');
            }
        };
    </script>
</body>

</html>