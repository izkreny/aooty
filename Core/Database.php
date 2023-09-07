<?php

namespace Core;
use \PDO as PDO;
use \PDOException as PDOException;

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct($dsn)
    {
        try {
            $this->conn = new PDO($dsn);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error establishing a database connection!";
            echo $e->getMessage(); // Only in Development environment
        }
    }

    public static function getInstance($dsn)
    {
        if (self::$instance === null)
        {
            self::$instance = new Database($dsn);
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
