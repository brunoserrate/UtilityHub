<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Utils\Helpers\UnitConverterHelper;

class UnitConverterRepository extends BaseRepository {

    public function convert($params) {

        $result = $this->validateFields($params);

        if(!$result['success']) {
            return $result;
        }

        $from = $params['from'];
        $to = $params['to'];
        $value = $params['value'];
        $type = $params['type'];

        if (!UnitConverterHelper::validadeType($type)) {
            return $this->sendError('invalid_type', $type);
        }

        try {
            $result = UnitConverterHelper::convert($from, $to, $value, $type);

            if(!$result['success']) {
                return $this->sendError('converter_not_found', [ 'type' => $type]);
            }

            return $this->sendSuccess('conversion_success', [
                'value' => $result['value'],
                'from' => $from,
                'to' => $to
            ]);
        } catch (\Throwable $th) {
            return $this->sendError('conversion_error', ['error'=>$th->getMessage()]);
        }
    }

    private function validateFields($params) {
        $requiredFields = ['from', 'to', 'value', 'type'];

        foreach ($requiredFields as $field) {
            if (!isset($params[$field])) {
                return $this->sendError('missing_field', ['field'=>$field]);
            }
        }

        return $this->sendSuccess('fields_validated', []);
    }
}