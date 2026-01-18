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
        $sql = "INSERT INTO Category (CategoryName, CategoryLimit) VALUES (:categoryName, :categoryLimit)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':categoryName' => $category->getName(),
            ':categoryLimit' => $category->getLimit()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM Category";
        $result = $this->pdo->query($sql);
        $categories = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['id'], $row['categoryname'], $row['categorylimit']);
        }
        return $categories;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM Category WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Category($row['id'], $row['categoryname'], $row['categorylimit']);
        }
        return null;
    }

    public function findByName($name)
    {
        $sql = "SELECT * FROM Category WHERE CategoryName = :categoryName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':categoryName' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Category($row['id'], $row['categoryname'], $row['categorylimit']);
        }
        return null;
    }

    public function update(Category $category)
    {
        $sql = "UPDATE Category SET CategoryName = :categoryName, CategoryLimit = :categoryLimit WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $category->getId(),
            ':categoryName' => $category->getName(),
            ':categoryLimit' => $category->getLimit()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Category WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
