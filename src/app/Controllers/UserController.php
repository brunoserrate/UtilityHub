<?php

namespace App\Controllers;

use App\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller {

    protected $page = "Login";

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function index() {
        $this->renderPartial('auth/login');
    }

    public function register() {
        $this->renderPartial('auth/register');
    }

    public function login() {

        $user = $this->userRepository->searchUser($_POST);

        if (!$user) {
            $this->renderPartial('auth/login', ['error' => 'Usuário não encontrado']);
            return;
        }

        if (!password_verify($password, $user->password)) {
            $this->renderPartial('auth/login', ['error' => 'Senha incorreta']);
            return;
        }

        $_SESSION['user'] = $user;
        header('Location: /');
    }
}