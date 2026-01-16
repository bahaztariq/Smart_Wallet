<?php

namespace App\Repositories\Interfaces;

use App\Models\Income;

interface IncomeRepositoryInterface
{
    public function create(Income $income);
    public function findAll();
    public function findById($id);
    public function findByUserId($userId);
    public function findByCategory($category);
    public function update(Income $income);
    public function delete($id);
}
