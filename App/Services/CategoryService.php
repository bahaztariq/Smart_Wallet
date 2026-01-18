<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory($name, $limit)
    {
        $category = new Category(null, $name, $limit);
        return $this->categoryRepository->create($category);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function updateCategory($id, $name, $limit)
    {
        $category = $this->categoryRepository->findById($id);
        if ($category) {
            $category->setName($name);
            $category->setLimit($limit);
            return $this->categoryRepository->update($category);
        }
        return false;
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
