<?php

    namespace Controller;

    include_once '../Core/Config.php';
    include_once '../Core/Database.php';
    include_once '../Model/User.php';
    include_once '../View/Registration.php';

    class Registration
    {
        private $model;
        private $view;
        private $messages = [];

        public function __construct()
        {
            $mysqlConfig = new \Core\Config('/var/www/config/mysql.ini');
            $database = \Core\Database::getInstance();
            $this->model = new \Model\User($database->connect($mysqlConfig->getPdoDsnForDatabase('aooty')));
            $this->view = new \View\Registration();
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

        private function checkEmailFormat($email)
        {
            // https://www.php.net/manual/en/filter.examples.validation.php
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                $this->messages[] = "Email formats is not valid!";

                return false;
            }
        }

        private function checkPasswords($password, $passwordConfirmed)
        {
            if ($password === $passwordConfirmed) {
                return true;
            } else {
                $this->messages[] = "Passwords are not identical!";

                return false;
            }
        }

        private function checkEmail($email)
        {
            if ($this->model->checkExistence($email, 'email')) {
                $this->messages[] = "The email address entered already exists in the system.";

                return false;
            } else {
                return true;
            }
        }

        private function sendActivationEmail($data)
        {
            // TODO: Send activation email with the token

            $this->messages[] = "An email has NOT been sent to your email address containing an activation link.";
        }

        public function process($data)
        {
            if (
                $this->checkEmail($data['email'])
                and $this->checkEmailFormat($data['email'])
                and $this->checkPasswords($data['password'], $data['passwordConfirmed']) 
            ) {
                // https://www.php.net/manual/en/function.password-hash.php
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // https://www.php.net/manual/en/function.random-bytes.php
                // https://www.php.net/manual/en/function.bin2hex
                $data['token'] = bin2hex(random_bytes(8));

                // https://www.php.net/manual/en/function.htmlspecialchars
                // https://www.php.net/manual/en/function.strip-tags
                $data['name'] = htmlspecialchars(strip_tags($data['name']));
                $data['surname'] = htmlspecialchars(strip_tags($data['surname']));

                unset($data['passwordConfirmed']);
                
                if ($this->model->addUser($data)) {
                    $this->messages[] = "Your account has been created successfully!";
                    $this->sendActivationEmail($data);
                } else {
                    $this->messages[] = "Your account has NOT been created successfully!";
                }
            }
        }
    }

    $registration = new \Controller\Registration();
    
    if (!empty($_POST)) {
        $registration->process($_POST);
    }
    $registration->showMessages();
    $registration->showForm();
