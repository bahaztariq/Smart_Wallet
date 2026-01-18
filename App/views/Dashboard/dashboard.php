<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\IncomeRepository;
use App\Repositories\ExpenseRepository;

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    $incomeRepository = new IncomeRepository();
    $expenseRepository = new ExpenseRepository();

    // Fetch Incomes via Repository
    $incomes = $incomeRepository->findByUserId($userId);
    $totalIncome = 0;
    foreach ($incomes as $income) {
        $totalIncome += $income->getAmount();
    }

    // Fetch Expenses via Repository
    $expenses = $expenseRepository->findByUserId($userId);
    $totalExpense = 0;
    foreach ($expenses as $expense) {
        $totalExpense += $expense->getAmount();
    }

    $balance = $totalIncome - $totalExpense;
} catch (Exception $e) {
    // Handle error gracefully
    $totalIncome = 0;
    $totalExpense = 0;
    $balance = 0;
    $error = "Could not load financial data.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartWallet - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/icon.png">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <?php require __DIR__ . '/../layout/sidebar.php'; ?>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-gray-50">

            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-20">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
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

            <!-- Main Scrollable -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">

                <div class="max-w-7xl mx-auto">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Financial Overview</h1>
                        <p class="text-gray-500 text-sm mt-1">Track your wealth and spending habits.</p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Balance Card -->
                        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl p-6 text-white shadow-lg shadow-emerald-200">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-emerald-100 text-sm font-medium">Total Balance</p>
                                    <h3 class="text-3xl font-bold mt-1">$<?php echo number_format($balance, 2); ?></h3>
                                </div>
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                    <i class="fi fi-rr-wallet text-xl text-white"></i>
                                </div>
                            </div>
                            <div class="flex items-center text-emerald-100 text-xs">
                                <span>Available funds</span>
                            </div>
                        </div>

                        <!-- Income Card -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Total Income</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">$<?php echo number_format($totalIncome, 2); ?></h3>
                                </div>
                                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                                    <i class="fi fi-rr-arrow-trend-up text-xl"></i>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>

                        <!-- Expenses Card -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Total Expenses</p>
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">$<?php echo number_format($totalExpense, 2); ?></h3>
                                </div>
                                <div class="p-2 bg-red-50 rounded-lg text-red-500">
                                    <i class="fi fi-rr-arrow-trend-down text-xl"></i>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Financial Trends</h3>
                            <div class="relative h-72 w-full">
                                <canvas id="mainChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Distribution</h3>
                            <div class="relative h-64 w-full flex justify-center">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                            <div class="mt-6 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                        <span class="text-gray-600">Income</span>
                                    </div>
                                    <span class="font-medium text-gray-900"><?php echo number_format($totalIncome, 2); ?></span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                        <span class="text-gray-600">Expenses</span>
                                    </div>
                                    <span class="font-medium text-gray-900"><?php echo number_format($totalExpense, 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script>
        // Data from PHP
        const income = <?php echo $totalIncome; ?>;
        const expenses = <?php echo $totalExpense; ?>;

        // Doughnut Chart
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    data: [income, expenses],
                    backgroundColor: ['#10b981', '#ef4444'], // Emerald-500, Red-500
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });

        // Dummy data for Line Chart (Since we don't have historical data per month yet in the simple fetch)
        const ctxLine = document.getElementById('mainChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                        label: 'Income',
                        data: [income * 0.8, income * 0.9, income, income * 1.1, income * 1.05, income], // Mock pattern
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: [expenses * 0.85, expenses * 0.9, expenses, expenses * 0.95, expenses * 1.1, expenses], // Mock pattern
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
            }
        });
    </script>
</body>

</html>