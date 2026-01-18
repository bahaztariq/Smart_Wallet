<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\IncomeRepository;
use App\Repositories\ExpenseRepository;
use Exception;

class DashboardController extends Controller
{
    private IncomeRepository $incomeRepository;
    private ExpenseRepository $expenseRepository;

    public function __construct()
    {
        session_start();
        $this->incomeRepository = new IncomeRepository();
        $this->expenseRepository = new ExpenseRepository();
    }

    public function index(): void
    {
        $this->requireAuth();

        try {
            $userId = $this->getUserId();

            $incomes = $this->incomeRepository->findByUserId($userId);
            $totalIncome = 0;
            foreach ($incomes as $income) {
                $totalIncome += $income->getAmount();
            }

            $expenses = $this->expenseRepository->findByUserId($userId);
            $totalExpense = 0;
            foreach ($expenses as $expense) {
                $totalExpense += $expense->getAmount();
            }

            $balance = $totalIncome - $totalExpense;

            $this->view('Dashboard/dashboard.php', [
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'balance' => $balance,
                'error' => null
            ]);
        } catch (Exception $e) {
            $this->view('Dashboard/dashboard.php', [
                'totalIncome' => 0,
                'totalExpense' => 0,
                'balance' => 0,
                'error' => 'Could not load financial data.'
            ]);
        }
    }
}
