<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\PasswordGeneratorController;
use App\Controllers\UnitConverterController;
use App\Controllers\RandomNumberController;

use App\Router;

$router = new Router();

// Home
$router->get('/', HomeController::class, 'index');

// Login
$router->get('/login', UserController::class, 'index');
$router->post('/login', UserController::class, 'login');
$router->get('/register', UserController::class, 'register');
$router->post('/register', UserController::class, 'store');
$router->get('/logout', UserController::class, 'logout');

// App
$router->get('/app', HomeController::class, 'app');

// Password Generator
$router->get('/app/password-generator', PasswordGeneratorController::class, 'index');
$router->post('/app/password-generator', PasswordGeneratorController::class, 'generate');

// Unit Converter
$router->get('/app/unit-converter', UnitConverterController::class, 'index');
$router->post('/app/unit-converter', UnitConverterController::class, 'convert');

// Random Number Generator
$router->get('/app/random-number-generator', RandomNumberController::class, 'index');
$router->post('/app/random-number-generator', RandomNumberController::class, 'generate');

$router->dispatch();