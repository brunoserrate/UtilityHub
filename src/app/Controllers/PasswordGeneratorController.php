<?php

namespace App\Controllers;

use App\Controller;
use App\Repositories\PasswordGeneratorRepository;

class PasswordGeneratorController extends Controller {

    protected $page = "Password Generator";

    private $passwordGeneratorRepository;

    public function __construct() {
        $this->passwordGeneratorRepository = new PasswordGeneratorRepository();
    }

    public function index() {
        $this->template = "app_default";
        $this->renderPartial('app/index');
    }

}