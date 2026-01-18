<?php

namespace App\DataBase;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance;
    private pdo $pdo;


    private function __construct($dsn, $username, $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    public static function getInstance($dsn = null, $username = null, $password = null)
    {
        if (self::$instance === null) {
            $host = 'localhost';
            $db = 'smart_wallet';
            $user = 'postgres';
            $pass = '0000';

            $dsn = $dsn ?? "pgsql:host=$host;dbname=$db";
            $username = $username ?? $user;
            $password = $password ?? $pass;

            self::$instance = new Database($dsn, $username, $password);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
