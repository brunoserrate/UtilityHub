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

        $params = $_POST;

        $result = $this->userRepository->searchUser($params);

        if(!$result['success']) {
            $this->renderPartial('auth/login', ['error' => $result['message']]);
            return;
        }

        $user = $result['data'];

        $result = $this->userRepository->verifyPassword($params, $user);

        if(!$result['success']) {
            $this->renderPartial('auth/login', ['error' => $result['message']]);
            return;
        }

        $this->userRepository->login($user);

        unset($user['password']);

        $_SESSION['user'] = $user;
        header('Location: /');
    }

    public function store() {

        $params = $_POST;

        $result = $this->userRepository->store($params);

        if(!$result['success']) {
            $this->renderPartial('auth/register', ['error' => $result['message']]);
            return;
        }

        $this->renderPartial('auth/login', ['success' => 'Usuário cadastrado com sucesso!']);
    }
}