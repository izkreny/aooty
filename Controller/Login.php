<?php

    namespace Controller;

    include_once '../Core/Config.php';
    include_once '../Core/Database.php';
    include_once '../Model/User.php';
    include_once '../View/Login.php';

    class Login
    {
        private $model;
        private $view;
        private $messages = [];

        public function __construct()
        {
            $mysqlConfig = new \Core\Config('/var/www/config/mysql.ini');
            $database = \Core\Database::getInstance();
            $this->model = new \Model\User($database->connect($mysqlConfig->getPdoDsnForDatabase('aooty')));
            $this->view = new \View\Login();
        }

        public function showMessages()
        {
            if (!empty($this->messages)) {
                $this->view->showMessages($this->messages);
            }
        }

        public function showForm()
        {
            $this->view->showForm();
        }

        private function checkEmail($email)
        {
            if ($this->model->checkExistence($email, 'email')) {
                return true;
            } else {
                return false;
            }
        }

        public function process($data)
        {
            if ($this->checkEmail($data['email'])) { // TODO: Check if user is activated!!!
                if (password_verify($data['password'], $this->model->fetchPassword($data['email']))) {
                    $this->messages[] = "Login successful!";
                } else {
                    $this->messages[] = "Login unsuccessful.";
                }
            } else {
                $this->messages[] = "The email address entered does not exists in the system.";
            }
        }
    }

    $login = new \Controller\Login();
    
    if (!empty($_POST)) {
        $login->process($_POST);
    }
    $login->showMessages();
    $login->showForm();
