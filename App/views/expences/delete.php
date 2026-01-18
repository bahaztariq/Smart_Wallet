<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\ExpenseRepository;

if (isset($_GET['id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $userId = $_SESSION['user_id'];

    if ($id) {
        $expenseRepository = new ExpenseRepository();
        // Verify ownership
        $existing = $expenseRepository->findById($id);
        if ($existing && $existing->getUserId() === $userId) {
            $expenseRepository->delete($id);
        }
    }
}

header("Location: /expences");
exit;
