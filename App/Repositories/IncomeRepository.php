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
        $sql = "INSERT INTO Incomes (UserId, Amount, description, ExpenceDate) VALUES (:userId, :amount, :description, :date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':userId' => $income->getUserId(),
            ':amount' => $income->getAmount(),
            ':description' => $income->getDescription(),
            ':date' => $income->getDate()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM Incomes";
        $result = $this->pdo->query($sql);
        $incomes = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $incomes[] = $this->mapRowToIncome($row);
        }
        return $incomes;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM Incomes WHERE id = :id";
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
        $sql = "SELECT * FROM Incomes WHERE UserId = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        $incomes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $incomes[] = $this->mapRowToIncome($row);
        }
        return $incomes;
    }



    public function update(Income $income)
    {
        $sql = "UPDATE Incomes SET Amount = :amount, description = :description, ExpenceDate = :date WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $income->getId(),
            ':amount' => $income->getAmount(),
            ':description' => $income->getDescription(),
            ':date' => $income->getDate()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Incomes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    private function mapRowToIncome($row)
    {
        // Handling flexible case for PDO fetch
        $amount = $row['amount'] ?? $row['Amount'];
        $date = $row['expencedate'] ?? $row['ExpenceDate'];

        return new Income(
            $row['id'],
            $row['userid'] ?? $row['UserId'],
            $amount,
            $row['description'],
            $date
        );
    }
}
