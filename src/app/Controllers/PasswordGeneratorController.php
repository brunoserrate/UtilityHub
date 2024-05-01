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
        $this->page = __("Password Generator");
        $this->renderPartial('app/password-generator');
    }

    public function generate() {
        $this->template = "app_default";
        $this->page = __("Password Generator");
        $params = $_POST;

        $result = $this->passwordGeneratorRepository->generate($params);

        if(!$result['success']) {
            $this->renderPartial('app/password-generator', ['error' => $result['message']]);
            return;
        }

        $this->renderPartial('app/password-generator', ['passwords' => $result['data'] , 'success' => $result['message'] ]);
    }

}