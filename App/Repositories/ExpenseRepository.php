<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use App\DataBase\Database;
use PDO;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    private $db;
    private $pdo;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->pdo = $this->db->getConnection();
    }

    public function create(Expense $expense)
    {
        $sql = "INSERT INTO Expences (UserId, Amount, description, ExpenceDate, CategoryId) VALUES (:userId, :amount, :description, :date, :categoryId)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':userId' => $expense->getUserId(),
            ':amount' => $expense->getAmount(),
            ':description' => $expense->getDescription(),
            ':date' => $expense->getDate(),
            ':categoryId' => $expense->getCategory()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM Expences";
        $result = $this->pdo->query($sql);
        $expenses = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $expenses[] = $this->mapRowToExpense($row);
        }
        return $expenses;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM Expences WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapRowToExpense($row);
        }
        return null;
    }

    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM Expences WHERE UserId = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        $expenses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $expenses[] = $this->mapRowToExpense($row);
        }
        return $expenses;
    }

    public function findByCategory($category)
    {
        $sql = "SELECT * FROM Expences WHERE CategoryId = :category";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':category' => $category]);
        $expenses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $expenses[] = $this->mapRowToExpense($row);
        }
        return $expenses;
    }

    public function update(Expense $expense)
    {
        $sql = "UPDATE Expences SET Amount = :amount, description = :description, ExpenceDate = :date, CategoryId = :categoryId WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $expense->getId(),
            ':amount' => $expense->getAmount(),
            ':description' => $expense->getDescription(),
            ':date' => $expense->getDate(),
            ':categoryId' => $expense->getCategory()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Expences WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    private function mapRowToExpense($row)
    {
        $amount = $row['amount'] ?? $row['Amount'];
        $date = $row['expencedate'] ?? $row['ExpenceDate'];
        $category = $row['categoryid'] ?? $row['CategoryId'] ?? null;

        return new Expense(
            $row['id'],
            $row['userid'] ?? $row['UserId'],
            $amount,
            $row['description'],
            $date,
            $category
        );
    }
}
