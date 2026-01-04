 <aside class="w-64 bg-slate-900 min-h-screen text-white flex flex-col sticky top-0 hidden md:flex">
     <div class="p-6 flex-1">
         <div class="mb-10">
             <span class="text-2xl font-black text-blue-500">Ma<span class="text-white">Bagnole</span></span>
             <p class="text-[10px] text-slate-400 tracking-widest uppercase mt-1">Admin Panel</p>
         </div>

         <nav class="space-y-4">
             <a href="admin_dashboard.php" class="flex items-center gap-3 text-blue-500 font-bold bg-blue-500/10 p-3 rounded-xl">
                 <i class="fas fa-chart-line"></i> Dashboard
             </a>
             <a href="admin_fleet.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                 <i class="fas fa-car"></i> Fleet
             </a>
             <a href="admin_reservations.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                 <i class="fas fa-calendar-check"></i> Reservations
             </a>
             <a href="admin_categories.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                 <i class="fas fa-tags"></i> Categories
             </a>
             <a href="admin_reviews.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                 <i class="fas fa-star"></i> Manage Reviews
             </a>
             <a href="admin_clients.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                 <i class="fas fa-users"></i> Clients
             </a>
         </nav>
     </div>

     <div class="p-4 border-t border-slate-800">
         <a href="logout.php" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-bold">
             <i class="fas fa-sign-out-alt"></i> Logout
         </a>
     </div>
 </aside>