<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller {

    protected $page = "Home";

    public function index() {
        $this->template = "clean_default";
        $this->renderPartial('index');
    }

    public function app() {
        $this->template = "app_default";
        $this->renderPartial('app/index');
    }
}