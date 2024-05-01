<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Utils\Helpers\PasswordGeneratorHelper;

class PasswordGeneratorRepository extends BaseRepository {

    public function generate($params) {
        $passwordGeneratorHelper = new PasswordGeneratorHelper();

        $length = isset($params['length']) ? $params['length'] : 8;
        $samples = isset($params['samples']) ? $params['samples'] : 1;
        $useLowerCase = isset($params['useLowerCase']) ? $params['useLowerCase'] : true;
        $useUpperCase = isset($params['useUpperCase']) ? $params['useUpperCase'] : true;
        $useNumbers = isset($params['useNumbers']) ? $params['useNumbers'] : true;
        $useSymbols = isset($params['useSymbols']) ? $params['useSymbols'] : false;
        $useSimilarCharacters = isset($params['useSimilarCharacters']) ? $params['useSimilarCharacters'] : false;
        $uniqueCharacters = isset($params['uniqueCharacters']) ? $params['uniqueCharacters'] : false;

        try {
            $passwords = $passwordGeneratorHelper->generatePassword($length, $samples, $useLowerCase, $useUpperCase, $useNumbers, $useSymbols, $useSimilarCharacters, $uniqueCharacters);

            return $this->sendSuccess(__('Password generated successfully'), $passwords);
        } catch (\Throwable $th) {
            return $this->sendError(__('Error generating password'));
        }


    }

}