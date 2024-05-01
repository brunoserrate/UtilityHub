<?php

namespace App\Utils\Helpers\UnitConverter;

use App\Interfaces\ConverterInterface;

class TemperatureConverter implements ConverterInterface
{

    private $conversionTable = [];

    public function convert($from, $to, $value)
    {

        $from = strtolower($from);
        $to = strtolower($to);

        if ($from === $to) {
            return [
                'success' => true,
                'value' => $value
            ];
        }

        $this->conversionTable = $this->mountConversionTable();

        if (isset($this->conversionTable[$from][$to])) {
            $conversionFunction = $this->conversionTable[$from][$to];
            $value = $conversionFunction($value);
            return [
                'success' => true,
                'value' => $value
            ];
        } else {
            return [
                'success' => false,
                'message' => 'converter_not_found'
            ];
        }
    }

    private function mountConversionTable()
    {
        return [
            'celsius' => [
                'fahrenheit' => function ($value) {
                    return ($value * 9 / 5) + 32;
                },
                'kelvin' => function ($value) {
                    return $value + 273.15;
                }
            ],
            'fahrenheit' => [
                'celsius' => function ($value) {
                    return ($value - 32) * 5 / 9;
                },
                'kelvin' => function ($value) {
                    return ($value + 459.67) * 5 / 9;
                }
            ],
            'kelvin' => [
                'celsius' => function ($value) {
                    return $value - 273.15;
                },
                'fahrenheit' => function ($value) {
                    return ($value * 9 / 5) - 459.67;
                }
            ]
        ];
    }
}
