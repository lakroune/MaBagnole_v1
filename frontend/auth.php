<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl flex flex-col md:flex-row max-w-4xl w-full overflow-hidden">
        
        <div class="hidden md:flex md:w-1/2 bg-blue-600 p-12 text-white flex-col justify-center relative">
            <div class="z-10">
                <h2 class="text-4xl font-bold mb-4">Welcome to MaBagnole</h2>
                <p class="text-blue-100">Join our community and get access to the best premium vehicles at the touch of a button.</p>
            </div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-500 rounded-full opacity-50"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12">
            
            <div class="flex mb-8 border-b">
                <button onclick="showForm('login')" id="login-tab" class="flex-1 pb-4 text-center font-bold text-blue-600 border-b-2 border-blue-600 transition">Login</button>
                <button onclick="showForm('signup')" id="signup-tab" class="flex-1 pb-4 text-center font-bold text-gray-400 hover:text-gray-600 transition">Sign Up</button>
            </div>

            <form id="login-form" action="login.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="paword" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg mt-4">Sign In</button>
            </form>

            <form id="signup-form" action="signup.php" method="POST" class="space-y-4 hidden">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nom</label>
                        <input type="text" name="nomUtilisateur" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Prénom</label>
                        <input type="text" name="prenomUtilisateur" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Téléphone</label>
                        <input type="tel" name="telephone" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="06XXXXXXXX">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Ville</label>
                        <input type="text" name="ville" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="name@company.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="paword" required class="w-full mt-1 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg mt-4">Create Account</button>
            </form>

        </div>
    </div>

    <script>
        function showForm(type) {
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const loginTab = document.getElementById('login-tab');
            const signupTab = document.getElementById('signup-tab');

            if (type === 'login') {
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
                loginTab.classList.add('text-blue-600', 'border-blue-600');
                loginTab.classList.remove('text-gray-400');
                signupTab.classList.remove('text-blue-600', 'border-blue-600');
                signupTab.classList.add('text-gray-400');
            } else {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                signupTab.classList.add('text-blue-600', 'border-blue-600');
                signupTab.classList.remove('text-gray-400');
                loginTab.classList.remove('text-blue-600', 'border-blue-600');
                loginTab.classList.add('text-gray-400');
            }
        }
    </script>
</body>
</html>