<?php
namespace App\Utils\Helpers;

use App\Utils\Helpers\EnvLoader;

class JsonResponser {

  public static function success($data, $mensagem, $status, $language = 'en') {
    $languagePath = ROOT_PATH . DIRECTORY_SEPARATOR . EnvLoader::loadEnv()['LANGUAGES_PATH'];
    if(empty($language)){
      $language = 'en';
    }

    $messages = include $languagePath . DIRECTORY_SEPARATOR . $language . '.php';

    self::printResponse($messages, $data, true, $mensagem, $status, $language);
  }

  public static function error($data, $mensagem, $status, $language = 'en') {
    $languagePath = ROOT_PATH . DIRECTORY_SEPARATOR . EnvLoader::loadEnv()['LANGUAGES_PATH'];
    if(empty($language)){
      $language = 'en';
    }

    $messages = include $languagePath . DIRECTORY_SEPARATOR . $language . '.php';

    self::printResponse($messages, $data, false, $mensagem, $status, $language);
  }


  private static function printResponse($messagesData, $data, $success, $message, $status, $language) {
    echo json_encode([
      $messagesData['return_keys']['success'] => $success,
      $messagesData['return_keys']['status'] => $status,
      $messagesData['return_keys']['message'] => $message,
      $messagesData['return_keys']['data'] => $data,
      $messagesData['return_keys']['response_time'] => date('Y-m-d H:i:s')
    ]);
  }

}