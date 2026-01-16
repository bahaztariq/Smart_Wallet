<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\DataBase\Database;
use PDO;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $db;
    private $pdo;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->pdo = $this->db->getConnection();
    }

    public function create(Category $category)
    {
        $sql = "INSERT INTO categories (category, \"Limit\") VALUES (:category, :limit)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':category' => $category->getName(),
            ':limit' => $category->getLimit()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->pdo->query($sql);
        $categories = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['id'], $row['category'], $row['Limit']);
        }
        return $categories;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Category($row['id'], $row['category'], $row['Limit']);
        }
        return null;
    }

    public function findByName($name)
    {
        $sql = "SELECT * FROM categories WHERE category = :category";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':category' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Category($row['id'], $row['category'], $row['Limit']);
        }
        return null;
    }

    public function update(Category $category)
    {
        $sql = "UPDATE categories SET category = :category, \"Limit\" = :limit WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $category->getId(),
            ':category' => $category->getName(),
            ':limit' => $category->getLimit()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
