<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\ExpenseRepository;
use App\Repositories\CategoryRepository;
use App\Models\Expense;

class ExpenseController extends Controller
{
    private ExpenseRepository $expenseRepository;
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        session_start();
        $this->expenseRepository = new ExpenseRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId = $this->getUserId();
        $expenses = $this->expenseRepository->findByUserId($userId);
        $categories = $this->categoryRepository->findAll();

        if (isset($_GET['Filtred_Category']) && !empty($_GET['Filtred_Category'])) {
            $filteredCategory = filter_input(INPUT_GET, 'Filtred_Category', FILTER_VALIDATE_INT);
            if ($filteredCategory) {
                $expenses = $this->expenseRepository->findByCategory($filteredCategory);
            }
        }

        $expense_data = null;
        if (isset($_GET['edit_id'])) {
            $editId = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);
            if ($editId) {
                $expense_data = $this->expenseRepository->findById($editId);
                if ($expense_data && $expense_data->getUserId() !== $userId) {
                    $expense_data = null;
                }
            }
        }

        $this->view('expences/expences.php', [
            'expenses' => $expenses,
            'categories' => $categories,
            'expense_data' => $expense_data
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/expences');
        }

        $this->requireCSRF();

        $userId = $this->getUserId();
        $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $description = $this->sanitize($_POST['description'] ?? '');
        $date = $this->sanitize($_POST['Date'] ?? date('Y-m-d'));
        $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?: null;

        if ($amount && $description && $date) {
            $expense = new Expense(null, $userId, $amount, $description, $date, $categoryId);
            $this->expenseRepository->create($expense);
        }

        $this->redirect('/expences');
    }

    public function update(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/expences');
        }

        $this->requireCSRF();

        $userId = $this->getUserId();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $description = $this->sanitize($_POST['description'] ?? '');
        $date = $this->sanitize($_POST['Date'] ?? date('Y-m-d'));
        $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?: null;

        if ($id && $amount && $description && $date) {
            $existingExpense = $this->expenseRepository->findById($id);
            if ($existingExpense && $existingExpense->getUserId() === $userId) {
                $expense = new Expense($id, $userId, $amount, $description, $date, $categoryId);
                $this->expenseRepository->update($expense);
            }
        }

        $this->redirect('/expences');
    }

    public function delete(): void
    {
        $this->requireAuth();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $userId = $this->getUserId();

        if ($id) {
            $existingExpense = $this->expenseRepository->findById($id);
            if ($existingExpense && $existingExpense->getUserId() === $userId) {
                $this->expenseRepository->delete($id);
            }
        }

        $this->redirect('/expences');
    }
}
