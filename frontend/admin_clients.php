<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Manage Clients</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important; color: white !important; border-radius: 8px; border: none;
        }
        table.dataTable.no-footer { border-bottom: 1px solid #e2e8f0; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

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
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Client Directory</h2>
                <p class="text-slate-500">Monitor user activity and manage access permissions.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 overflow-hidden">
            <table id="clientTable" class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <th class="px-4 py-4">Client</th>
                        <th class="px-4 py-4">Email & Phone</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">AH</div>
                                <div>
                                    <p class="font-bold text-slate-800">Ahmed Hassan</p>
                                    <p class="text-[10px] text-slate-400 uppercase">ID: #992</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-slate-600">ahmed@example.com</p>
                            <p class="text-[10px] text-slate-400">+212 600-112233</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-green-50 text-green-600 border border-green-100">Active</span>
                        </td>
                        <td class="px-4 py-4">
                            <button onclick="confirmStatusChange(992, 'Ahmed Hassan', 'suspend')" 
                                    class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition text-xs font-bold">
                                <i class="fas fa-user-slash"></i> Suspend
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-4 opacity-60">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-400">KO</div>
                                <div>
                                    <p class="font-bold text-slate-800">Karim Omar</p>
                                    <p class="text-[10px] text-slate-400 uppercase">ID: #450</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 opacity-60">
                            <p class="text-sm font-medium text-slate-600">karim.o@mail.com</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Suspended</span>
                        </td>
                        <td class="px-4 py-4">
                            <button onclick="confirmStatusChange(450, 'Karim Omar', 'activate')" 
                                    class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition text-xs font-bold">
                                <i class="fas fa-user-check"></i> Activate
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="statusActionModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl text-center">
            <div id="modalIconContainer" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i id="modalIcon" class="fas"></i>
            </div>
            
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-2">Confirm Action</h3>
            <p class="text-slate-400 text-sm mb-8">
                Are you sure you want to change the status of <span id="modalClientName" class="font-bold text-slate-700"></span>?
            </p>
            
            <form action="process_client.php" method="POST" class="flex gap-3">
                <input type="hidden" name="idUtilisateur" id="modalUserId">
                <input type="hidden" name="action_type" id="modalActionType">
                
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-6 py-3 font-bold text-slate-400 bg-slate-50 rounded-xl hover:bg-slate-100 transition">
                    Cancel
                </button>
                <button type="submit" id="modalSubmitBtn" class="flex-1 px-6 py-3 text-white rounded-xl font-bold transition shadow-lg">
                    Confirm
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() { 
            $('#clientTable').DataTable({ 
                pageLength: 10,
                language: { search: "", searchPlaceholder: "Search clients..." }
            }); 
        });

        function confirmStatusChange(id, name, type) {
            const modal = document.getElementById('statusActionModal');
            const iconContainer = document.getElementById('modalIconContainer');
            const icon = document.getElementById('modalIcon');
            const title = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('modalSubmitBtn');
            
            document.getElementById('modalUserId').value = id;
            document.getElementById('modalActionType').value = type;
            document.getElementById('modalClientName').innerText = name;

            if (type === 'suspend') {
                iconContainer.className = "w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl";
                icon.className = "fas fa-user-lock";
                title.innerText = "Suspend Account";
                submitBtn.innerText = "Suspend";
                submitBtn.className = "flex-1 px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg shadow-red-100";
            } else {
                iconContainer.className = "w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl";
                icon.className = "fas fa-user-check";
                title.innerText = "Activate Account";
                submitBtn.innerText = "Activate";
                submitBtn.className = "flex-1 px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-600 shadow-lg shadow-green-100";
            }

            modal.classList.replace('hidden', 'flex');
        }

        function closeStatusModal() {
            document.getElementById('statusActionModal').classList.replace('flex', 'hidden');
        }
    </script>
</body>
</html>