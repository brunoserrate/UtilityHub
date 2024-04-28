<?php

namespace App\Controllers;

use App\Controller;

class UserController extends Controller {

    protected $page = "Login";

    public function index() {
        $this->renderPartial('auth/login');
    }

    public function register() {
        $this->renderPartial('auth/register');
    }
}