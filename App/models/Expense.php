<?php

namespace App\Models;

class Expense
{
    private ?int $id;
    private int $userId;
    private float $amount;
    private string $description;
    private string $date;
    private ?int $categoryId;

    public function __construct(?int $id, int $userId, float $amount, string $description, string $date, ?int $categoryId = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->description = $description;
        $this->date = $date;
        $this->categoryId = $categoryId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getCategory(): ?int
    {
        return $this->categoryId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setCategory(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
}
