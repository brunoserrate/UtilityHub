<?php

namespace App\Controllers;

use App\Controller;
use App\Repositories\RandomNumberRepository;

class RandomNumberController extends Controller {

    protected $page = "Random Number Generator";

    private $randomNumberRepository;

    public function __construct() {
        $this->randomNumberRepository = new RandomNumberRepository();
    }

    public function index() {
        $this->template = "app_default";
        $this->renderPartial('app/random-number-generator');
    }

    public function generate() {
        $this->template = "app_default";
        $params = $_POST;

        $result = $this->randomNumberRepository->generate($params);

        if(!$result['success']) {
            $this->renderPartial('app/random-number-generator', ['error' => $result['message']]);
            return;
        }

        $this->renderPartial('app/random-number-generator', ['values' => $result['data']['values'], 'statistic' => $result['data']['statistic'], 'success' => $result['message'] ]);

    }

}