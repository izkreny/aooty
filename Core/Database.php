<?php

    namespace Core;
    use \PDO as PDO;
    use \PDOException as PDOException;

    class Database
    {
        private static $instance = null;
        private $conn;

        private function __construct()
        {
        }

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function connect($dsn)
        {
            $this->conn = null;

            try {
                $this->conn = new PDO($dsn);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error establishing a database connection!";
                echo $e->getMessage(); // Only in Development environment
            }

            return $this->conn;
        }
    }
