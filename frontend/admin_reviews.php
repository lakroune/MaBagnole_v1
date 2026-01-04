<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Manage Reviews</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 12px; padding: 6px 12px; border: 1px solid #e2e8f0; outline: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important; color: white !important; border: none; border-radius: 8px;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-slate-900 min-h-screen text-white flex flex-col sticky top-0 hidden md:flex">
        <div class="p-6 flex-1">
            <div class="mb-10">
                <span class="text-2xl font-black text-blue-500">Ma<span class="text-white">Bagnole</span></span>
            </div>
            <nav class="space-y-4">
                <a href="admin_dashboard.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="admin_fleet.php" class="flex items-center gap-3 text-slate-400 hover:text-white transition p-3">
                    <i class="fas fa-car"></i> Manage Fleet
                </a>
                <a href="admin_reviews.php" class="flex items-center gap-3 text-blue-500 font-bold bg-blue-500/10 p-3 rounded-xl">
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

    <main class="flex-1 p-4 md:p-10">
        <header class="mb-10">
            <h2 class="text-3xl font-bold text-slate-800">Customer Reviews</h2>
            <p class="text-slate-500">Moderate and manage feedback from your clients.</p>
        </header>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8">
            <table id="reviewsTable" class="w-full">
                <thead>
                    <tr class="text-left text-slate-400 uppercase text-[11px] font-black tracking-wider">
                        <th class="pb-4">Client / Vehicle</th>
                        <th class="pb-4">Review Content</th>
                        <th class="pb-4">Rating</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 text-sm">Ahmed Berrada</span>
                                <span class="text-[10px] text-blue-500 font-bold uppercase">Porsche 911</span>
                            </div>
                        </td>
                        <td class="py-6 max-w-xs">
                            <p class="text-sm text-slate-600 italic">"The car was in perfect condition. Amazing experience!"</p>
                            <span class="text-[10px] text-slate-400">Oct 24, 2025</span>
                        </td>
                        <td class="py-6 text-orange-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </td>
                        <td class="py-6">
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase">Pending</span>
                        </td>
                        <td class="py-6">
                            <div class="flex gap-2">
                                <button onclick="approveReview(1)" class="w-9 h-9 bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="openDeleteModal(1)" class="w-9 h-9 bg-red-50 text-red-500 rounded-xl hover:bg-red-600 hover:text-white transition" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 text-sm">Sara Khalil</span>
                                <span class="text-[10px] text-blue-500 font-bold uppercase">Range Rover</span>
                            </div>
                        </td>
                        <td class="py-6 max-w-xs">
                            <p class="text-sm text-slate-600">"Great service but the pickup was a bit late."</p>
                            <span class="text-[10px] text-slate-400">Oct 20, 2025</span>
                        </td>
                        <td class="py-6 text-orange-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star text-slate-200"></i>
                        </td>
                        <td class="py-6">
                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase">Visible</span>
                        </td>
                        <td class="py-6 text-slate-400 italic text-xs">No actions needed</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl"><i class="fas fa-trash-alt"></i></div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Delete Review?</h3>
            <p class="text-slate-400 text-sm mb-6">This feedback will be permanently removed.</p>
            <div class="flex gap-3">
                <button onclick="toggleModal('deleteModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-50 rounded-xl">Cancel</button>
                <button class="flex-1 py-3 bg-red-500 text-white rounded-xl font-bold">Yes, Delete</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reviewsTable').DataTable({
                pageLength: 10,
                ordering: false,
                dom: '<"flex justify-between mb-4"f>rtip'
            });
        });

        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function approveReview(id) {
        
            alert("Review " + id + " has been approved and is now live!");
        }
    </script>
</body>
</html>