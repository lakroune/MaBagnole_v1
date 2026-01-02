<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->role !== 'client') :
    header('Location: login.php');
    exit();
else :

?>

    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <p class="text-xs font-bold text-slate-800">Welcome, <?php echo $_SESSION['Utilisateur']->nomUtilisateur; ?></p>
            <a href="logout.php" class="text-[10px] text-red-500 font-black uppercase tracking-widest hover:underline">Logout</a>
        </div>
        <div class="w-10 h-10 rounded-full bg-blue-600 border-2 border-blue-100 flex items-center justify-center text-white font-bold shadow-sm">
            <?php echo $_SESSION['Utilisateur']->nomUtilisateur[0]; ?>
        </div>
    </div>

<?php endif; ?>