<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\IncomeRepository;

if (isset($_GET['id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $userId = $_SESSION['user_id'];

    if ($id) {
        $incomeRepository = new IncomeRepository();
        // Verify ownership
        $existingIncome = $incomeRepository->findById($id);
        if ($existingIncome && $existingIncome->getUserId() === $userId) {
            $incomeRepository->delete($id);
        }
    }
}

header("Location: /incomes");
exit;
