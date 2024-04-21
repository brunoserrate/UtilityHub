<?php

namespace App\Utils\Helpers;

class RandomNumberHelper {

    public static function generate($min = 1, $max = 100, $samples = 1, $unique = false) {
        $numbers = [];

        $list = range($min, $max);

        for ($i = 0; $i < $samples; $i++) {
            $index = array_rand($list);
            $number = $list[$index];

            if ($unique) {
                unset($list[$index]);
            }

            $numbers[] = $number;
        }

        return $numbers;
    }

    public static function generateStatistic($numbers) {
        $statistic = [
            'min_output' => min($numbers),
            'max_output' => max($numbers),
            'average_output' => array_sum($numbers) / count($numbers),
            'data' => []
        ];

        foreach ($numbers as $value) {
            if(!isset($statistic['data'][$value])) {
                $statistic['data'][$value] = 0;
            }

            $statistic['data'][$value]++;
        }

        return $statistic;
    }


}