<?php

namespace App\Repositories;

use App\Utils\Helpers\ResponseUtil;

class BaseRepository {

    /**
     * @param string $message Mensagem de retorno
     * @param array  $data   Dados de retorno
     * @param bool   $success Status de sucesso
     * @param int    $code   Código de retorno
     *
     * @return array
     */
    public function sendResponse($message, $data = [], $success = true, $code = 200) {
    	$response = ResponseUtil::makeResponse($message, $data, $success, $code);
    	$response['response_time'] =  date('Y-m-d H:i-s');
        return $response;
    }

    /**
     * @param string $error Mensagem de erro
     * @param array  $data  Dados de retorno
     * @param int    $code  Código de retorno
     *
     * @return array
     */
    public function sendError($error, $data = [], $code = 404) {

    	$response = ResponseUtil::makeError($error, $data, $code);
    	$response['response_time'] =  date('Y-m-d H:i-s');
    	return $response;

    }

    /**
     * @param string $message Mensagem de sucesso
     * @param array  $result  Dados de retorno
     * @param int    $code    Código de retorno
     *
     * @return array
     */
    public function sendSuccess( $message, $result, $code = 200)
    {
    	$response = ResponseUtil::makeSuccess($message, $result, $code);
    	$response['response_time'] =  date('Y-m-d H:i-s');
        return $response;
    }
}