<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Categorie;



session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->role !== 'admin') {
    header('Location: login.php');
    exit();
} else {

    $categories = Categorie::getAllCategories();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Manage Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important;
            color: white !important;
            border-radius: 8px;
            border: none;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex">

    <?php include_once('sidebar.php'); ?>
    <main class="flex-1 p-4 md:p-10 w-full">
        <div class="flex justify-between items-center mb-8 w-full">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Vehicle Categories</h2>
                <p class="text-slate-500">Organize your fleet by types and classes.</p>
            </div>
            <button onclick="toggleModal('addCategoryModal')" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 max-w-4xl w-full">
            <table id="catTable" class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Category Name</th>
                        <th class="px-4 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($categories)  ?>
                    <?php foreach ($categories as $category) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-4 py-4 font-bold text-slate-400 text-sm">#<?php echo $category->idCategorie; ?></td>
                            <td class="px-4 py-4">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl font-bold text-sm"><?php echo $category->titreCategorie; ?></span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <button onclick="openEditModal(<?php echo $category->idCategorie; ?>, '<?php echo $category->titreCategorie; ?>')" class="w-9 h-9 rounded-xl bg-slate-100 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button onclick="openDeleteModal(<?php echo $category->idCategorie; ?>)" class="w-9 h-9 rounded-xl bg-slate-100 text-red-500 hover:bg-red-600 hover:text-white transition flex items-center justify-center">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addCategoryModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-800 mb-6 text-center">New Category</h3>
            <form action="../controler/AdminControler.php" method="POST" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="page" value="admin_categories">
                <div>
                    <label class="text-xs font-bold uppercase text-slate-400 block mb-2">Category Name</label>
                    <input type="text" name="nomCategorie" required class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="toggleModal('addCategoryModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-100 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editCategoryModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-800 mb-6 text-center">Edit Category</h3>
            <form action="../controler/AdminControler.php" method="POST" class="space-y-4">
                <input type="hidden" name="idCategorie" id="edit_cat_id">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="page" value="admin_categories">

                <div>
                    <label class="text-xs font-bold uppercase text-slate-400 block mb-2">Category Name</label>
                    <input type="text" name="nomCategorie" id="edit_cat_name" required class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="toggleModal('editCategoryModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-100 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl"><i class="fas fa-exclamation-circle"></i></div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Delete Category?</h3>
            <p class="text-slate-400 text-sm mb-6">This will affect all vehicles linked to this category.</p>
            <form action="../controler/AdminControler.php" method="POST" class="flex gap-3">
                <input type="hidden" name="idCategorie" id="delete_cat_id">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="page" value="admin_categories">
                <button type="button" onclick="toggleModal('deleteModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-50 rounded-xl">Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-red-500 text-white rounded-xl font-bold shadow-lg shadow-red-100">Delete</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#catTable').DataTable({
                pageLength: 7,
                searching: false,
                lengthChange: false
            });
        });

        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function openEditModal(id, name) {
            document.getElementById('edit_cat_id').value = id;
            document.getElementById('edit_cat_name').value = name;
            toggleModal('editCategoryModal');
        }

        function openDeleteModal(id) {
            document.getElementById('delete_cat_id').value = id;
            toggleModal('deleteModal');
        }
    </script>
</body>

</html>