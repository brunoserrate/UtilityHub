<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Utils\Helpers\RandomNumberHelper;

class RandomNumberRepository extends BaseRepository {

    public function generate($params) {
        $min = $params['min'] ?? 1;
        $max = $params['max'] ?? 100;
        $samples = $params['samples'] ?? 1;
        $unique = $params['unique'] ?? false;

        try {
            $values = RandomNumberHelper::generate($min, $max, $samples, $unique);

            $data = [
                'values' => $values,
                'statistic' => RandomNumberHelper::generateStatistic($values),
            ];

            return $this->sendSuccess(__('Random number generated'), $data);

        } catch (\Throwable $th) {
            return $this->sendError(__('Failed to generate random number'), ['error' => $th->getMessage()]);
        }
    }

}