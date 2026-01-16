<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IncomeRepositoryInterface;
use App\Models\Income;
use App\DataBase\Database;
use PDO;

class IncomeRepository implements IncomeRepositoryInterface
{
    private $db;
    private $pdo;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->pdo = $this->db->getConnection();
    }

    public function create(Income $income)
    {
        // Assuming 'category' column exists in 'incomes' table since there was a getByCategory method.
        // If it was missing in original create(), I'm adding it now to be consistent.
        $sql = "INSERT INTO incomes (UserID, montant, description, date_, category) VALUES (:userId, :amount, :description, :date, :category)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':userId' => $income->getUserId(),
            ':amount' => $income->getAmount(),
            ':description' => $income->getDescription(),
            ':date' => $income->getDate(),
            ':category' => $income->getCategory()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM incomes";
        $result = $this->pdo->query($sql);
        $incomes = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $incomes[] = $this->mapRowToIncome($row);
        }
        return $incomes;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM incomes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapRowToIncome($row);
        }
        return null;
    }

    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM incomes WHERE UserID = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        $incomes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $incomes[] = $this->mapRowToIncome($row);
        }
        return $incomes;
    }

    public function findByCategory($category)
    {
        $sql = "SELECT * FROM incomes WHERE category = :category";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':category' => $category]);
        $incomes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $incomes[] = $this->mapRowToIncome($row);
        }
        return $incomes;
    }

    public function update(Income $income)
    {
        $sql = "UPDATE incomes SET montant = :amount, description = :description, date_ = :date, category = :category WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $income->getId(),
            ':amount' => $income->getAmount(),
            ':description' => $income->getDescription(),
            ':date' => $income->getDate(),
            ':category' => $income->getCategory()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM incomes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    private function mapRowToIncome($row)
    {
        // Handling potential missing category key if column doesn't exist (but I assume it does)
        $category = isset($row['category']) ? $row['category'] : null;
        return new Income(
            $row['id'],
            $row['UserID'],
            $row['montant'],
            $row['description'],
            $row['date_'],
            $category
        );
    }
}
