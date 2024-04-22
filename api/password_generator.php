<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Utils\Helpers\PasswordGeneratorHelper;
use App\Models\TokenModel;

$acceptLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
$languageUsed = LocalizationHelper::getLanguage($acceptLanguage);
$messageData = include (LocalizationHelper::getLanguagePath() . $languageUsed) . ".php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    JsonResponser::error([], $messageData['error']['general']['method_not_allowed'], 405, $languageUsed);
    die();
}

$renderTemplate = false;
$headers = apache_request_headers();
$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : null;

// Get the post data
if (!isset($_SESSION["requested_via_browser"]) || !$_SESSION["requested_via_browser"]) {
    $query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;

    if (!empty($query)) {

        $query = explode('&', $query);
        $queryData = [];

        foreach ($query as $value) {
            $key = explode('=', $value)[0];
            $queryValue = explode('=', $value)[1];

            $queryData[$key] = $queryValue;
        }

        $length = isset($queryData['length']) ? $queryData['length'] : 8;
        $samples = isset($queryData['samples']) ? $queryData['samples'] : 1;
        $useLowerCase = isset($queryData['useLowerCase']) ? $queryData['useLowerCase'] : true;
        $useUpperCase = isset($queryData['useUpperCase']) ? $queryData['useUpperCase'] : true;
        $useNumbers = isset($queryData['useNumbers']) ? $queryData['useNumbers'] : true;
        $useSymbols = isset($queryData['useSymbols']) ? $queryData['useSymbols'] : false;
        $useSimilarCharacters = isset($queryData['useSimilarCharacters']) ? $queryData['useSimilarCharacters'] : false;
        $uniqueCharacters = isset($queryData['uniqueCharacters']) ? $queryData['uniqueCharacters'] : false;

    } else {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $length = isset($body['length']) ? $body['length'] : 8;
        $samples = isset($body['samples']) ? $body['samples'] : 1;
        $useLowerCase = isset($body['useLowerCase']) ? $body['useLowerCase'] : true;
        $useUpperCase = isset($body['useUpperCase']) ? $body['useUpperCase'] : true;
        $useNumbers = isset($body['useNumbers']) ? $body['useNumbers'] : true;
        $useSymbols = isset($body['useSymbols']) ? $body['useSymbols'] : false;
        $useSimilarCharacters = isset($body['useSimilarCharacters']) ? $body['useSimilarCharacters'] : false;
        $uniqueCharacters = isset($body['uniqueCharacters']) ? $body['uniqueCharacters'] : false;
    }
} else {
    // Get via $_GET
    $renderTemplate = true;

    $length = isset($_GET['length']) ? $_GET['length'] : 8;
    $samples = isset($_GET['samples']) ? $_GET['samples'] : 1;
    $useLowerCase = isset($_GET['useLowerCase']) ? $_GET['useLowerCase'] : true;
    $useUpperCase = isset($_GET['useUpperCase']) ? $_GET['useUpperCase'] : true;
    $useNumbers = isset($_GET['useNumbers']) ? $_GET['useNumbers'] : true;
    $useSymbols = isset($_GET['useSymbols']) ? $_GET['useSymbols'] : false;
    $useSimilarCharacters = isset($_GET['useSimilarCharacters']) ? $_GET['useSimilarCharacters'] : false;
    $uniqueCharacters = isset($_GET['uniqueCharacters']) ? $_GET['uniqueCharacters'] : false;
}

// Request doen't have authorization header
if (empty($authorization)) {
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$authorization = str_replace('Bearer ', '', $authorization);

// Check token
$tokenModel = new TokenModel();

$token = $tokenModel->get(
    0,
    1,
    'id',
    'DESC',
    ['*'],
    [
        [
            'key' => 'token',
            'operator' => '=',
            'value' => $authorization
        ],
        [
            'key' => 'expires_at',
            'operator' => '>',
            'value' => date('Y-m-d H:i:s')
        ]
    ],
);

// Error in get token. Server side
if (!$token['success']) {
    JsonResponser::error([], $messageData['error']['general']['fail_retrieving_data'], 500, $languageUsed);
    die();
}

// Token not found. Need to login again
if (empty($token['data'])) {
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$passwordHelper = new PasswordGeneratorHelper();

if($samples > 100) {
    $samples = 100;
}

if($length > 50) {
    $length = 50;
}

$password = $passwordHelper->generatePassword(
    $length,
    $samples,
    $useLowerCase,
    $useUpperCase,
    $useNumbers,
    $useSymbols,
    $useSimilarCharacters,
    $uniqueCharacters
);

// TODO: For future updates: Add a render template option
header('Content-Type: application/json; charset=utf-8');

JsonResponser::success($password, $messageData['success']['general']['data_retrieved'], 200, $languageUsed);
