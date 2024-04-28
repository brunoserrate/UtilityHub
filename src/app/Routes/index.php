<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Router;

$router = new Router();

// Home
$router->get('/', HomeController::class, 'index');

// Login
$router->get('/login', UserController::class, 'index');
$router->get('/register', UserController::class, 'register');

$router->dispatch();