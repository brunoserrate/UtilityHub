<?php

namespace App\Utils\Helpers;

/*
    Got from InfyOm
*/

class ResponseUtil
{
    public static function makeResponse($message, array $data = [], $success = true, $code = 200)
    {
        return [
            'success' => $success,
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [], $code = 404)
    {
        $res = [
            'success' => false,
            'code'    => $code,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeSuccess($message, array $data = [], $code = 200)
    {
        return [
            'success' => true,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ];
    }
}