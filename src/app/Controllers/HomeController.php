<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller {

    protected $page = "Home";

    public function index() {
        $this->addCSS('default.css');

        $this->renderPartial('index');
    }
}