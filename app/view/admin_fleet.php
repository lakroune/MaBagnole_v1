<?php

namespace app\view;

require_once __DIR__ . '/../../vendor/autoload.php';

use app\model\Vehicule;
use app\model\Categorie;



session_start();

if (!isset($_SESSION['Utilisateur']) || $_SESSION['Utilisateur']->getRole() !== 'admin') {
    header('Location: login.php');
    exit();
} else {

    $vehicule = new Vehicule();
    $vehicules = $vehicule->getAllVehicules();

    $categorie = new Categorie();
    $categories = $categorie->getAllCategories();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole | Fleet Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./css/style.css">
    
</head>

<body class="bg-slate-50 min-h-screen flex">

    <?php include('sidebar.php'); ?>
    <main class="flex-1 p-4 md:p-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Fleet Management</h2>
                <p class="text-slate-500">Full control over your rental inventory.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="toggleModal('bulkAddModal')" class="bg-slate-800 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-700 transition flex items-center gap-2">
                    <i class="fas fa-layer-group"></i> Add in Bulk
                </button>
                <button onclick="toggleModal('addVehicleModal')" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Single Vehicle
                </button>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 overflow-hidden">
            <table id="fleetTable" class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-400 uppercase text-[11px] font-black tracking-wider">
                        <th class="px-4 py-4">Vehicle</th>
                        <th class="px-4 py-4">Category</th>
                        <th class="px-4 py-4">Specs</th>
                        <th class="px-4 py-4">Price</th>
                        <th class="px-4 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($vehicules)    ?>
                    <?php foreach ($vehicules as $vehicule) : ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="<?= $vehicule->getImageVehicule() ?>" class="w-14 h-9 object-cover rounded-lg">
                                    <div>
                                        <p class="font-bold text-slate-800"><?= $vehicule->getMarqueVehicule() ?></p>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-tighter"><?= $vehicule->getModeleVehicule() ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase"><?= $vehicule->getIdCategorie() ?></span></td>
                            <td class="text-xs text-slate-600"><?= $vehicule->getTypeBoiteVehicule() ?> • <?= $vehicule->getTypeCarburantVehicule() ?> </td>
                            <td class="font-bold text-slate-800"><?= $vehicule->getPrixVehicule() ?>MAD</td>
                            <td>
                                <div class="flex gap-2">
                                    <button onclick="openEditModal({id:<?= $vehicule->getIdVehicule() ?>, marque:'<?= $vehicule->getMarqueVehicule() ?>', modele:'<?= $vehicule->getModeleVehicule() ?>', annee:'<?= $vehicule->getAnneeVehicule() ?>', couleur:'<?= $vehicule->getCouleurVehicule() ?>', boite:'<?= $vehicule->getTypeBoiteVehicule() ?>', carburant:'<?= $vehicule->getTypeCarburantVehicule() ?>', prix:'<?= $vehicule->getPrixVehicule() ?>', cat:'<?= $vehicule->getIdCategorie() ?>', img:'<?= $vehicule->getImageVehicule() ?>'})" class="w-8 h-8 rounded-lg bg-slate-100 text-blue-600 hover:bg-blue-600 hover:text-white transition"><i class="fas fa-edit text-xs"></i></button>
                                    <button onclick="openDeleteModal({id:<?= (int) $vehicule->getIdVehicule() ?>})" class="w-8 h-8 rounded-lg bg-slate-100 text-red-500 hover:bg-red-600 hover:text-white transition"><i class="fas fa-trash text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addVehicleModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-3xl p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold text-slate-800 mb-6">New Vehicle</h3>
            <form action="../controler/AdminControler.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" name="page" value="admin_fleet">
                <input type="hidden" name="action" value="add">
                <div><label class="text-xs font-bold uppercase text-slate-400">Marque</label><input type="text" name="marqueVehicule" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Modèle</label><input type="text" name="modeleVehicule" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Année</label><input type="number" name="anneeVehicule" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Couleur</label><input type="text" name="couleurVehicule" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Boîte</label><select name="typeBoiteVehicule" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="manuelle">Manuelle</option>
                        <option value="automatique">Automatique</option>
                    </select></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Carburant</label><select name="typeCarburantVehicule" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="essence">Essence</option>
                        <option value="diesel">Diesel</option>
                        <option value="electrique">Électrique</option>
                        <option value="hybride">Hybride</option>
                    </select></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Prix / Jour (MAD)</label><input type="text" name="prixVehicule" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Catégorie</label><select name="idCategorie" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie->getIdCategorie() ?>"><?= $categorie->getTitreCategorie() ?></option>
                        <?php endforeach; ?>
                    </select></div>
                <div class="md:col-span-2"><label class="text-xs font-bold uppercase text-slate-400">Image URL</label><input type="text" name="imageVehicule" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="md:col-span-2 flex justify-end gap-3 mt-4"><button type="button" onclick="toggleModal('addVehicleModal')" class="px-6 py-2 text-slate-400 font-bold">Cancel</button><button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100">Add to Fleet</button></div>
            </form>
        </div>
    </div>

    <div id="editVehicleModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-3xl p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold text-slate-800 mb-6">Update Vehicle</h3>
            <form action="../controler/AdminControler.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" name="idVehicule" id="edit_id">
                <input type="hidden" name="page" value="admin_fleet">
                <input type="hidden" name="action" value="update">
                <div><label class="text-xs font-bold uppercase text-slate-400">Marque</label><input type="text" name="marqueVehicule" id="edit_marque" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Modèle</label><input type="text" name="modeleVehicule" id="edit_modele" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Année</label><input type="number" name="anneeVehicule" id="edit_annee" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Couleur</label><input type="text" name="couleurVehicule" id="edit_couleur" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Boîte</label><select name="typeBoiteVehicule" id="edit_boite" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="manuelle">Manuelle</option>
                        <option value="automatique">Automatique</option>
                    </select></div>
                <div><label class="text-xs font-bold uppercase text-slate-400">Carburant</label><select name="typeCarburantVehicule" id="edit_carburant" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="essence">Essence</option>
                        <option value="diesel">Diesel</option>
                        <option value="electrique">Électrique</option>
                        <option value="hybride">Hybride</option>
                    </select></div>
                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Prix / Jour</label><input type="text" name="prixVehicule" id="edit_prix" required class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Catégorie</label>
                    <select name="idCategorie" id="edit_cat" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie->getIdCategorie() ?>"><?= $categorie->getTitreCategorie() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold uppercase text-slate-400">Image URL</label>
                    <input type="text" name="imageVehicule" id="edit_image" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-slate-400 mt-2">Image URL</p>

                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-4"><button type="button" onclick="toggleModal('editVehicleModal')" class="px-6 py-2 text-slate-400 font-bold">Cancel</button><button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg">Save Changes</button></div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 shadow-2xl text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl"><i class="fas fa-trash-alt"></i></div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Are you sure?</h3>
            <p class="text-slate-400 text-sm mb-6">This action cannot be undone.</p>
            <form action="../controler/AdminControler.php" method="POST" class="flex gap-3">
                <input type="hidden" name="idVehicule" id="delete_id" required>
                <input type="hidden" name="page" value="admin_fleet">
                <input type="hidden" name="action" value="delete">
                <button type="button" onclick="toggleModal('deleteModal')" class="flex-1 py-3 font-bold text-slate-400 bg-slate-50 rounded-xl">No, Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-red-500 text-white rounded-xl font-bold shadow-lg shadow-red-100">Yes, Delete</button>
            </form>
        </div>
    </div>
    <div id="bulkAddModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-3xl p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Mass Vehicle Import</h3>
                <button onclick="toggleModal('bulkAddModal')" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="../controler/AdminControler.php" method="POST">
                <input type="hidden" name="page" value="admin_fleet">
                <input type="hidden" name="action" value="import">
                <p class="text-sm text-slate-500 mb-4 font-medium">Paste multiple vehicles below. Format: <span class="bg-slate-100 p-1 rounded text-blue-600 font-mono text-xs">Marque, Model, Year, color , transmission, type of fuel, price,id category, image </span> (One per line)</p>
                <textarea name="bulkData" rows="8" class="w-full p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm" placeholder="Porsche, 911, 2023, Red, Automatic, Gas, 500, 1, https://example.com/image.jpg&#10;BMW, M4, 2023, Black, Manual, Diesel, 600, 2, https://example.com/image2.jpg"></textarea>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('bulkAddModal')" class="px-6 py-2 text-slate-400 font-bold">Cancel</button>
                    <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold shadow-lg">Start Import</button>
                </div>
            </form>
        </div>
    </div>
    <div id="statusModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[200] p-4">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center relative">
            <button onclick="closeStatusModal()" class="absolute top-6 right-6 text-slate-300 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>

            <div id="statusIconContainer" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl border-4 border-white shadow-sm">
                <i id="statusIcon" class="fas"></i>
            </div>

            <h3 id="statusTitle" class="text-2xl font-black text-slate-800 mb-2"></h3>
            <p id="statusMessage" class="text-slate-500 text-sm mb-8 leading-relaxed"></p>

            <button onclick="closeStatusModal()" id="statusBtn" class="w-full text-white py-4 rounded-2xl font-black shadow-lg transition active:scale-95">
                Dismiss
            </button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/main.js"></script>>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('add') && urlParams.get('add') === "success") {
                showStatusModal('success', 'Operation Successful', 'The  fleet has been added successfully.');
            } else if (urlParams.has('delete') && urlParams.get('delete') === "success") {
                showStatusModal('success', 'Operation Successful', 'The fleet has been deleted successfully.');
            } else if (urlParams.has('update') && urlParams.get('update') === "success") {
                showStatusModal('success', 'Operation Successful', 'The fleet has been updated successfully.');
            }  else if (urlParams.has('import') && urlParams.get('import') === "success") {
                showStatusModal('success', 'Operation Successful', 'The fleet has been imported successfully.');
            } else if (urlParams.has('add') || urlParams.has('delete') || urlParams.has('update') || urlParams.has('import')) {
                showStatusModal('error', 'Operation Failed', 'Something went wrong. Please try again.');
            }
        };

        $(document).ready(function() {
            $('#fleetTable').DataTable({
                pageLength: 8,
                 ordering: true,
                dom: '<"flex justify-between items-center mb-6"f>rtip',
                language: {
                    search: "",
                    searchPlaceholder: "Search fleet..."
                }
            });
        });
    </script>
</body>

</html>