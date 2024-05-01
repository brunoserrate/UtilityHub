<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Router;

$router = new Router();

// Home
$router->get('/', HomeController::class, 'index');

// Login
$router->get('/login', UserController::class, 'index');
$router->post('/login', UserController::class, 'login');
$router->get('/register', UserController::class, 'register');
$router->post('/register', UserController::class, 'store');

// App
$router->get('/app', HomeController::class, 'app');

// Password Generator
$router->get('/app/password-generator', HomeController::class, 'passwordGenerator');

$router->dispatch();