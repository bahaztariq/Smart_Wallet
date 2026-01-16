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
        $sql = "INSERT INTO expences (UserID, montant, description, date_, category) VALUES (:userId, :amount, :description, :date, :category)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':userId' => $expense->getUserId(),
            ':amount' => $expense->getAmount(),
            ':description' => $expense->getDescription(),
            ':date' => $expense->getDate(),
            ':category' => $expense->getCategory()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM expences";
        $result = $this->pdo->query($sql);
        $expenses = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $expenses[] = $this->mapRowToExpense($row);
        }
        return $expenses;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM expences WHERE id = :id";
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
        $sql = "SELECT * FROM expences WHERE UserID = :userId";
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
        $sql = "SELECT * FROM expences WHERE category = :category";
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
        $sql = "UPDATE expences SET montant = :amount, description = :description, date_ = :date, category = :category WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $expense->getId(),
            ':amount' => $expense->getAmount(),
            ':description' => $expense->getDescription(),
            ':date' => $expense->getDate(),
            ':category' => $expense->getCategory()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM expences WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    private function mapRowToExpense($row)
    {
        return new Expense(
            $row['id'],
            $row['UserID'],
            $row['montant'],
            $row['description'],
            $row['date_'],
            $row['category']
        );
    }
}
