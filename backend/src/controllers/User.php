<?php

namespace App\controllers;

use App\models\Usermodel;

class User extends Controller {
    protected object $user;

    public function __construct($param) {
        $this->user = new Usermodel();

        parent::__construct($param);
    }

    public function postUser() {
        $this->user->add($this->body);

        return $this->user->getLast();
    }

    public function deleteUser() {
        return $this->user->delete(intval($this->params['id']));
    }

    public function getUser() {
        return $this->user->get(intval($this->params['id']));
    }
}
