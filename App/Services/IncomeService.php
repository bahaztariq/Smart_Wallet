<?php

namespace App\Services;

use App\Repositories\Interfaces\IncomeRepositoryInterface;
use App\Models\Income;

class IncomeService
{
    private $incomeRepository;

    public function __construct(IncomeRepositoryInterface $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    public function createIncome($userId, $amount, $description, $date)
    {
        $income = new Income(null, $userId, $amount, $description, $date);
        return $this->incomeRepository->create($income);
    }

    public function getAllIncomes()
    {
        return $this->incomeRepository->findAll();
    }

    public function getIncomeById($id)
    {
        return $this->incomeRepository->findById($id);
    }

    public function getIncomesByUserId($userId)
    {
        return $this->incomeRepository->findByUserId($userId);
    }



    public function updateIncome($id, $amount, $description, $date)
    {
        $income = $this->incomeRepository->findById($id);
        if ($income) {
            $income->setAmount($amount);
            $income->setDescription($description);
            $income->setDate($date);
            return $this->incomeRepository->update($income);
        }
        return false;
    }

    public function deleteIncome($id)
    {
        return $this->incomeRepository->delete($id);
    }
}
