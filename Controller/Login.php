<?php

    namespace Controller;

    class Login
    {
        private $model;
        private $view;
        private $messages = [];

        public function __construct()
        {
            $this->model = new \Model\User();
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
                $this->messages[] = "The email address entered does not exists in the system.";

                return false;
            }
        }

        private function isActive($email)
        {
            if ($this->model->checkStatus($email)) {
                return true;
            } else {
                $this->messages[] = "Your account is NOT activated. You can NOT login!";

                return false;
            }
        }

        public function process($data)
        {
            if ($this->checkEmail($data['email']) and $this->isActive($data['email'])) {
                if (password_verify($data['password'], $this->model->fetchPassword($data['email']))) {
                    $this->messages[] = "Login successful!";
                } else {
                    $this->messages[] = "Login unsuccessful, invalid password.";
                }
            }
        }
    }

    $login = new \Controller\Login();
    
    if (!empty($_POST)) {
        $login->process($_POST);
    }
    $login->showMessages();
    $login->showForm();
