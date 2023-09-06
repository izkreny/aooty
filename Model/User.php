<?php

    namespace Model;
    use \PDO as PDO;

    include_once '../Core/Config.php';
    include_once '../Core/Database.php';

    class User
    {
        private $conn;
        private $table = 'users';

        public function __construct()
        {
            $config = new \Core\Config('config.ini');
            $database = \Core\Database::getInstance($config->getMySQLPDODSN());
            $this->conn = $database->getConnection();
        }

        public function checkExistence($string, $column)
        {
            $querry = "SELECT {$column} FROM {$this->table} WHERE {$column} = :string";
            $stmt = $this->conn->prepare($querry);
            $stmt->bindParam(':string', $string, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function checkStatus($email)
        {
            $querry = "SELECT status FROM {$this->table} WHERE email = :email AND status = 1";
            $stmt = $this->conn->prepare($querry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function fetchPassword($email)
        {
            $querry = "SELECT password FROM {$this->table} WHERE email = :email";
            $stmt = $this->conn->prepare($querry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $password = $stmt->fetch();
            // var_dump($password);

            return $password['password'];
        }

        public function activateUser($token)
        {
            $querry = "UPDATE {$this->table} SET status = 1, token = '' WHERE token = :token";
            $stmt = $this->conn->prepare($querry);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function addUser($data)
        {
            $querry = "
                INSERT INTO {$this->table}
                (name, surname, email, password, token)
                VALUES
                (:name, :surname, :email, :password, :token)
            ";

            if ($this->conn->prepare($querry)->execute($data)) {
                return true;
            } else {
                return false;
            }
        }

    }
