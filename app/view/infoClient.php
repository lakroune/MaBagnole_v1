<?php


if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'client') :

?>


    <div class="flex items-center gap-4">
        <a href="login.php" class="text-sm font-bold text-slate-600">Sign In</a>
        <a href="register.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Register</a>
    </div>


<?php else : ?>
    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <p class="text-xs font-bold text-slate-800">Welcome, <?php echo $_SESSION['Utilisateur']->getNomUtilisateur(); ?></p>
            <button onclick="window.location.href='./index.php'" class="text-[10px] text-red-500 font-black uppercase tracking-widest hover:underline">Logout</button>
        </div>
        <div class="w-10 h-10 rounded-full bg-blue-600 border-2 border-blue-100 flex items-center justify-center text-white font-bold shadow-sm">
            <?= strtoupper($_SESSION['Utilisateur']->getNomUtilisateur()[0] . "." . $_SESSION['Utilisateur']->getPrenomUtilisateur()[0]) ?>
        </div>
    </div>

<?php endif; ?>