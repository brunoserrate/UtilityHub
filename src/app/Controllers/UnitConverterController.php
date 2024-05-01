<?php

namespace App\Controllers;

use App\Controller;
use App\Repositories\UnitConverterRepository;

class UnitConverterController extends Controller {

    protected $page = "Unit Converter";

    private $unitConverterRepository;

    private $unitSelectOptions = [
        'celsius' => 'Celsius',
        'fahrenheit' => 'Fahrenheit',
        'kelvin' => 'Kelvin'
    ];

    public function __construct() {
        $this->unitConverterRepository = new UnitConverterRepository();
    }

    public function index() {
        $this->template = "app_default";
        $this->renderPartial('app/unit-converter', [
            'unitSelectOptions' => $this->unitSelectOptions
        ]);
    }

    public function convert() {
        $this->template = "app_default";
        $params = $_POST;

        $result = $this->unitConverterRepository->convert($params);

        if(!$result['success']) {

            $error =  [
                'error' => $result['message'],
                'unitSelectOptions' => $this->unitSelectOptions
            ];

            if(!empty($result['data']['field']))
                $error['field'] = $result['data']['field'];

            if(!empty($result['data']['error']))
                $error['error'] = $result['data']['error'];

            $this->renderPartial('app/unit-converter', $error);
            return;
        }

        $this->renderPartial('app/unit-converter', [
            'result' =>[
                'value' => $result['data']['value'],
                'from' => $this->unitSelectOptions[$result['data']['from']],
                'to' => $this->unitSelectOptions[$result['data']['to']]
            ],
            'unitSelectOptions' => $this->unitSelectOptions
        ]);
    }

}