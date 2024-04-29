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
}