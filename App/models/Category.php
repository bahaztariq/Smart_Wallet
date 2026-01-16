<?php

namespace App\Models;

class Category
{
    private ?int $id;
    private string $name;
    private float $limit;

    public function __construct(?int $id, string $name, float $limit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->limit = $limit;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setLimit(float $limit): void
    {
        $this->limit = $limit;
    }
}
