<?php

namespace App\Services;

use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;

class ExpenseService
{
    private $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function createExpense($userId, $amount, $description, $date, $category)
    {
        $expense = new Expense(null, $userId, $amount, $description, $date, $category);
        return $this->expenseRepository->create($expense);
    }

    public function getAllExpenses()
    {
        return $this->expenseRepository->findAll();
    }

    public function getExpenseById($id)
    {
        return $this->expenseRepository->findById($id);
    }

    public function getExpensesByUserId($userId)
    {
        return $this->expenseRepository->findByUserId($userId);
    }

    public function getExpensesByCategory($category)
    {
        return $this->expenseRepository->findByCategory($category);
    }

    public function updateExpense($id, $amount, $description, $date, $category)
    {
        $expense = $this->expenseRepository->findById($id);
        if ($expense) {
            $expense->setAmount($amount);
            $expense->setDescription($description);
            $expense->setDate($date);
            $expense->setCategory($category);
            return $this->expenseRepository->update($expense);
        }
        return false;
    }

    public function deleteExpense($id)
    {
        return $this->expenseRepository->delete($id);
    }
}
