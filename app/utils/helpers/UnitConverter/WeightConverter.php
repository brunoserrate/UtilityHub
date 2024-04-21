<?php

namespace App\Utils\Helpers\UnitConverter;

use App\Interfaces\ConverterInterface;

class WeightConverter implements ConverterInterface {

    public function convert($from, $to, $value) {
        return [
            'success' => false,
            'message' => 'not_implemented_yet',
        ];
    }

}