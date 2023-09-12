<?php

namespace Model;
use \PDO as PDO;

class User
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $config = new \Core\Config('config.ini');
        $db = \Core\Database::getInstance($config->getMySQLPDODSN());
        $this->conn = $db->getConnection();
    }

    public function checkExistence($string, $column)
    {
        $query = "SELECT {$column} FROM {$this->table} WHERE {$column} = :string";
        $stmt = $this->conn->prepare($query);
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
        $query = "SELECT status FROM {$this->table} WHERE email = :email AND status = 1";
        $stmt = $this->conn->prepare($query);
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
        $query = "SELECT password FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $password = $stmt->fetch();

        // TODO: Optimize this variable...
        return $password['password'];
    }

    public function activateUser($token)
    {
        $query = "UPDATE {$this->table} SET status = 1, token = '' WHERE token = :token";
        $stmt = $this->conn->prepare($query);
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
        $query = "INSERT INTO {$this->table}"
            . "(name, surname, email, password, token)"
            . "VALUES"
            . "(:name, :surname, :email, :password, :token)";

        if ($this->conn->prepare($query)->execute($data)) {
            return true;
        } else {
            return false;
        }
    }
}
