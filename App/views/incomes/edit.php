<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\IncomeRepository;
use App\Models\Income;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $description = htmlspecialchars($_POST['description'] ?? '');
    $date = $_POST['Date'] ?? date('Y-m-d');
    $userId = $_SESSION['user_id'];

    if ($id && $amount && $description && $date) {
        $incomeRepository = new IncomeRepository();

        // Verify ownership
        $existingIncome = $incomeRepository->findById($id);
        if ($existingIncome && $existingIncome->getUserId() === $userId) {
            $income = new Income($id, $userId, $amount, $description, $date);
            $incomeRepository->update($income);
        }
    }

    header("Location: /incomes");
    exit;
}
