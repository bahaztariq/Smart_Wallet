<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\IncomeRepository;
use App\Models\Income;

class IncomeController extends Controller
{
    private IncomeRepository $incomeRepository;

    public function __construct()
    {
        session_start();
        $this->incomeRepository = new IncomeRepository();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId = $this->getUserId();
        $incomes = $this->incomeRepository->findByUserId($userId);

        $income_data = null;
        if (isset($_GET['edit_id'])) {
            $editId = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);
            if ($editId) {
                $income_data = $this->incomeRepository->findById($editId);
                if ($income_data && $income_data->getUserId() !== $userId) {
                    $income_data = null;
                }
            }
        }

        $this->view('incomes/incomes.php', [
            'incomes' => $incomes,
            'income_data' => $income_data
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/incomes');
        }

        $this->requireCSRF();

        $userId = $this->getUserId();
        $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $description = $this->sanitize($_POST['description'] ?? '');
        $date = $this->sanitize($_POST['Date'] ?? date('Y-m-d'));

        if ($amount && $description && $date) {
            $income = new Income(null, $userId, $amount, $description, $date);
            $this->incomeRepository->create($income);
        }

        $this->redirect('/incomes');
    }

    public function update(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/incomes');
        }

        $this->requireCSRF();

        $userId = $this->getUserId();
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $amount = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $description = $this->sanitize($_POST['description'] ?? '');
        $date = $this->sanitize($_POST['Date'] ?? date('Y-m-d'));

        if ($id && $amount && $description && $date) {
            $existingIncome = $this->incomeRepository->findById($id);
            if ($existingIncome && $existingIncome->getUserId() === $userId) {
                $income = new Income($id, $userId, $amount, $description, $date);
                $this->incomeRepository->update($income);
            }
        }

        $this->redirect('/incomes');
    }

    public function delete(): void
    {
        $this->requireAuth();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $userId = $this->getUserId();

        if ($id) {
            $existingIncome = $this->incomeRepository->findById($id);
            if ($existingIncome && $existingIncome->getUserId() === $userId) {
                $this->incomeRepository->delete($id);
            }
        }

        $this->redirect('/incomes');
    }
}
