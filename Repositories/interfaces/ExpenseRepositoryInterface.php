<?php

namespace App\Repositories\Interfaces;

use App\Models\Expense;

interface ExpenseRepositoryInterface
{
    public function create(Expense $expense);
    public function findAll();
    public function findById($id);
    public function findByUserId($userId);
    public function findByCategory($category);
    public function update(Expense $expense);
    public function delete($id);
}
