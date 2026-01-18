<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Core\CSRF;
use App\Repositories\ExpenseRepository;
use App\Repositories\CategoryRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$userId = $_SESSION['user_id'];
$expenseRepository = new ExpenseRepository();
$categoryRepository = new CategoryRepository();

$expenses = $expenseRepository->findByUserId($userId);

$categories = $categoryRepository->findAll();

// Handle Filter
if (isset($_GET['Filtred_Category']) && !empty($_GET['Filtred_Category'])) {
    $filteredCategory = (int)$_GET['Filtred_Category'];
    $expenses = $expenseRepository->findByCategory($filteredCategory);
}


// Handle Edit Data
$expense_data = null;
if (isset($_GET['edit_id'])) {
    $expense_data = $expenseRepository->findById($_GET['edit_id']);
    if ($expense_data && $expense_data->getUserId() !== $userId) {
        $expense_data = null;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartWallet - Expenses</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/icon.png">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false, modalOpen: false, editModalOpen: <?php echo isset($_GET['edit_id']) ? 'true' : 'false'; ?>, deleteModalOpen: false, deleteUrl: '' }">

    <div class="flex h-screen overflow-hidden">

        <?php require __DIR__ . '/../layout/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-gray-50">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-20">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fi fi-rr-menu-burger text-xl"></i>
                </button>
                <div class="flex-1 flex justify-end items-center gap-4">
                    <div class="flex items-center gap-3 text-sm">
                        <span class="hidden md:block text-gray-500">Welcome,</span>
                        <span class="font-semibold text-gray-900"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold border border-emerald-200">
                            <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Expense Management</h1>
                            <p class="text-sm text-gray-500 mt-1">Track your spending habits and categories.</p>
                        </div>
                        <button @click="modalOpen = true" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg shadow-sm flex items-center gap-2 transition-all">
                            <i class="fi fi-rr-plus"></i>
                            <span>Add Expense</span>
                        </button>
                    </div>

                    <!-- Expenses Table -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 class="font-bold text-gray-800">Transactions</h3>
                            <form action="" method="GET">
                                <select name="Filtred_Category" onchange="this.form.submit()" class="text-sm p-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat->getId(); ?>" <?php echo (isset($_GET['Filtred_Category']) && $_GET['Filtred_Category'] == $cat->getId()) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat->getName()); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-500 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Description</th>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Amount</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php if (empty($expenses)): ?>
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                                No expense records found.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($expenses as $expense): ?>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 font-mono text-xs text-gray-400">#<?php echo $expense->getId(); ?></td>
                                                <td class="px-6 py-4 font-medium text-gray-900"><?php echo htmlspecialchars($expense->getDescription()); ?></td>
                                                <td class="px-6 py-4 text-gray-500"><?php echo htmlspecialchars($expense->getDate()); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                        <?php
                                                        $catName = "Unknown";
                                                        foreach ($categories as $c) {
                                                            if ($c->getId() == $expense->getCategory()) {
                                                                $catName = $c->getName();
                                                                break;
                                                            }
                                                        }
                                                        echo htmlspecialchars($catName);
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 font-medium text-red-600">-<?php echo number_format($expense->getAmount(), 2); ?> DH</td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex justify-end gap-3">
                                                        <a href="?edit_id=<?php echo $expense->getId(); ?>" class="text-blue-500 hover:text-blue-700 transition-colors bg-blue-50 p-2 rounded-lg" title="Edit">
                                                            <i class="fi fi-rr-edit"></i>
                                                        </a>
                                                        <button @click="deleteModalOpen = true; deleteUrl = '/expences/delete?id=<?php echo $expense->getId(); ?>'" class="text-red-500 hover:text-red-700 transition-colors bg-red-50 p-2 rounded-lg" title="Delete">
                                                            <i class="fi fi-rr-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>

        <!-- Add Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm" x-cloak style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Add New Expense</h3>
                            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-500">
                                <i class="fi fi-rr-cross"></i>
                            </button>
                        </div>
                        <form action="/expences/add" method="POST" class="space-y-4">
                            <?php echo CSRF::field(); ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (DH)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fi fi-rr-dollar"></i>
                                    </div>
                                    <input type="number" step="0.01" name="montant" placeholder="0.00" class="pl-10 w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category_id" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat->getId(); ?>"><?php echo htmlspecialchars($cat->getName()); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="Date" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required></textarea>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-3 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 sm:text-sm">
                                    Save Expense
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <?php if (isset($_GET['edit_id']) && $expense_data): ?>
            <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm" x-cloak>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex justify-between items-center mb-5">
                                <h3 class="text-lg leading-6 font-bold text-gray-900">Edit Expense</h3>
                                <button onclick="window.location.href='expences.php'" class="text-gray-400 hover:text-gray-500">
                                    <i class="fi fi-rr-cross"></i>
                                </button>
                            </div>
                            <form action="/expences/edit" method="POST" class="space-y-4">
                                <?php echo CSRF::field(); ?>
                                <input type="hidden" name="id" value="<?php echo $expense_data->getId(); ?>">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (DH)</label>
                                    <input type="number" step="0.01" name="montant" value="<?php echo htmlspecialchars($expense_data->getAmount()); ?>" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category_id" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat->getId(); ?>" <?php echo ($expense_data->getCategory() == $cat->getId()) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat->getName()); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                    <input type="date" name="Date" value="<?php echo htmlspecialchars($expense_data->getDate()); ?>" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" rows="3" class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required><?php echo htmlspecialchars($expense_data->getDescription()); ?></textarea>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-3 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 sm:text-sm">
                                        Update Expense
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="deleteModalOpen = false">
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                    <div class="bg-white p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fi fi-rr-exclamation text-red-600 text-lg"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900">Delete Expense Record</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this record? This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a :href="deleteUrl" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </a>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>