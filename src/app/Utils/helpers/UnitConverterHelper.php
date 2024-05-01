<?php

namespace App\Utils\Helpers;

use App\Utils\Helpers\UnitConverter\AreaConverter;
use App\Utils\Helpers\UnitConverter\LengthConverter;
use App\Utils\Helpers\UnitConverter\TemperatureConverter;
use App\Utils\Helpers\UnitConverter\TimeConverter;
use App\Utils\Helpers\UnitConverter\VolumeConverter;
use App\Utils\Helpers\UnitConverter\WeightConverter;

class UnitConverterHelper {

    public static function convert($from, $to, $value, $type) {
        $converter = null;

        switch ($type) {
            case 'area':
                $converter = new AreaConverter();
                break;
            case 'length':
                $converter = new LengthConverter();
                break;
            case 'temperature':
                $converter = new TemperatureConverter();
                break;
            case 'time':
                $converter = new TimeConverter();
                break;
            case 'volume':
                $converter = new VolumeConverter();
                break;
            case 'weight':
                $converter = new WeightConverter();
                break;
            default:
                return [
                    'success' => false,
                    'message' => 'converter_not_found'
                ];
                break;
        }

        return $converter->convert($from, $to, $value);
    }

    public static function validadeType($type) {
        $validTypes = [
            'area',
            'length',
            'temperature',
            'time',
            'volume',
            'weight'
        ];

        return in_array($type, $validTypes);
    }

}