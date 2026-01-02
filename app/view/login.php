<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Shake animation for error attention */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row shadow-blue-100/50">

        <div class="md:w-1/2 bg-slate-900 relative p-12 flex flex-col justify-between overflow-hidden">
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <a href="index.php"> <span class="text-2xl font-black text-blue-500">Ma<span class="text-white">Bagnole</span></span></a>
            </div>

            <div class="relative z-10">
                <h2 class="text-4xl font-black text-white leading-tight mb-4">
                    Drive the <br><span class="text-blue-500">Excellence.</span>
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    Access your account to manage your bookings or your premium fleet.
                </p>
            </div>

            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=800"
                class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay">
        </div>

        <div class="md:w-1/2 p-8 md:p-16">
            <div class="mb-10">
                <h1 class="text-3xl font-black text-slate-800 mb-2">Welcome Back</h1>
                <p class="text-slate-400 font-medium">Please enter your details.</p>
            </div>

            <form action="../controler/UtilisateurControler.php" method="POST" class="space-y-6">
                <input type="hidden" name="page" value="login">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="email" name="email" required
                            placeholder="admin@mabagnole.com"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="password" name="password" required
                            placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-xs font-bold text-slate-500">Remember me</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-blue-600 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all">
                    Sign In
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-sm text-slate-400 font-medium">
                    Don't have an account?
                    <a href="register.php" class="text-blue-600 font-black hover:underline">Create Account</a>
                </p>
            </div>
        </div>
    </div>
    <div id="loginErrorModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative animate-shake">
            <button onclick="closeLoginError()" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>

            <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl border-4 border-white shadow-sm">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Login Failed</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                The email or password you entered is incorrect. Please check your credentials and try again.
            </p>

            <button onclick="closeLoginError()" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-lg hover:bg-slate-800 transition active:scale-95">
                Try Again
            </button>
        </div>
    </div>


    <script>
        function showLoginError() {
            const modal = document.getElementById('loginErrorModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLoginError() {
            document.getElementById('loginErrorModal').classList.add('hidden');
        }

        // Auto-check for error parameter in URL
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('login')) {
                showLoginError();
            }
        };
    </script>
</body>

</html>