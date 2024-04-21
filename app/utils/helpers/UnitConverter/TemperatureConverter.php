<?php

namespace App\Utils\Helpers\UnitConverter;

use App\Interfaces\ConverterInterface;

class TemperatureConverter implements ConverterInterface
{

    public function convert($from, $to, $value) {

        $from = strtolower($from);
        $to = strtolower($to);

        if ($from === $to) {
            return [
                'success' => true,
                'value' => $value
            ];
        }

        switch ($from) {
            case 'celsius':
                switch ($to) {
                    case 'fahrenheit':
                        $value = ($value * 9 / 5) + 32;
                        break;
                    case 'kelvin':
                        $value = $value - 273.15;
                        break;
                    default:
                        return [
                            'success' => false,
                            'message' => 'converter_not_found'
                        ];
                        break;
                }
                break;
            case 'fahrenheit':
                switch ($to) {
                    case 'celsius':
                        $value = ($value - 32) * 5 / 9;
                        break;
                    case 'kelvin':
                        $value = ($value - 32) * 5 / 9 + 273.15;
                        break;
                    default:
                        return [
                            'success' => false,
                            'message' => 'converter_not_found'
                        ];
                        break;
                }
                break;
            case 'kelvin':
                switch ($to) {
                    case 'celsius':
                        $value = $value + 273.15;
                        break;
                    case 'fahrenheit':
                        $value = ($value - 273.15) * 9 / 5 + 32;
                        break;
                    default:
                        return [
                            'success' => false,
                            'message' => 'converter_not_found'
                        ];
                        break;
                }
                break;
            default:
                return [
                    'success' => false,
                    'message' => 'converter_not_found'
                ];
                break;
        }

        return [
            'success' => true,
            'value' => $value
        ];
    }
}
