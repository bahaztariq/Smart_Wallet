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

    $userId = $_SESSION['user_id'];
    $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $description = htmlspecialchars($_POST['description'] ?? '');
    $date = $_POST['Date'] ?? date('Y-m-d');

    if ($amount && $categoryId && $description && $date) {
        $expenseRepository = new ExpenseRepository();
        $expense = new Expense(null, $userId, $amount, $description, $date, $categoryId);
        $expenseRepository->create($expense);
    }

    header("Location: /expences");
    exit;
}
