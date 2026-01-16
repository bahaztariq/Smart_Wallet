<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function create(Category $category);
    public function findAll();
    public function findById($id);
    public function findByName($name);
    public function update(Category $category);
    public function delete($id);
}
