<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\ExpenseRepository;
use App\Models\Expense;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $description = htmlspecialchars($_POST['description'] ?? '');
    $date = $_POST['Date'] ?? date('Y-m-d');
    $userId = $_SESSION['user_id'];

    if ($id && $amount && $categoryId && $description && $date) {
        $expenseRepository = new ExpenseRepository();

        // Verify ownership
        $existing = $expenseRepository->findById($id);
        if ($existing && $existing->getUserId() === $userId) {
            $expense = new Expense($id, $userId, $amount, $description, $date, $categoryId);
            $expenseRepository->update($expense);
        }
    }

    header("Location: /expences");
    exit;
}
