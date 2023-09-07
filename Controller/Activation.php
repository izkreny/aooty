<?php

namespace Controller;

class Activation 
{
    private $model;
    private $view;
    private $messages = [];

    public function __construct()
    {
        $this->model = new \Model\User();
        $this->view = new \View\Activation();
    }

    public function showMessages()
    {
        if (!empty($this->messages)) {
            $this->view->showMessages($this->messages);
        }
    }

    private function checkToken($token)
    {
        if ($this->model->checkExistence($token, 'token')) {
            return true;
        } else {
            return false;
        }
    }

    public function process($token)
    {
        if ($this->checkToken($token)) {
            if ($this->model->activateUser($token)) {
                $this->messages[] = "Your account has been successfully activated. You can now login!";
            } else {
                $this->messages[] = "Unsuccessful account activation.";
            }
        } else {
            $this->messages[] = "Invalid token!";
        }
    }
}

$activation = new \Controller\Activation();

if (!empty($_GET['token'])) {
    $activation->process($_GET['token']);
}
$activation->showMessages();
