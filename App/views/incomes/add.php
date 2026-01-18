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

    $userId = $_SESSION['user_id'];
    $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $description = htmlspecialchars($_POST['description'] ?? '');
    $date = $_POST['Date'] ?? date('Y-m-d');

    if ($amount && $description && $date) {
        $incomeRepository = new IncomeRepository();
        $income = new Income(null, $userId, $amount, $description, $date);
        $incomeRepository->create($income);
    }

    header("Location: /incomes");
    exit;
}
