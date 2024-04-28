<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Utils\Helpers\UnitConverterHelper;
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

        $params = $queryData;
    } else {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $params = $body;
    }

    // $from, $to, $value, $type

    $from = isset($params['from']) ? $params['from'] : null;
    $to = isset($params['to']) ? $params['to'] : null;
    $value = isset($params['value']) ? $params['value'] : null;
    $type = isset($params['type']) ? $params['type'] : null;
} else {
    // Get via $_GET
    $renderTemplate = true;

    $from = isset($_GET['from']) ? $_GET['from'] : null;
    $to = isset($_GET['to']) ? $_GET['to'] : null;
    $value = isset($_GET['value']) ? $_GET['value'] : null;
    $type = isset($_GET['type']) ? $_GET['type'] : null;
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

// Empty values
if (empty($from) || empty($to) || empty($value) || empty($type)) {
    JsonResponser::error([], $messageData['error']['general']['parameters_empty'], 400, $languageUsed);
    die();
}

if(!UnitConverterHelper::validadeType($type)) {
    JsonResponser::error([], $messageData['error']['unit_converter']['converter_not_found'], 400, $languageUsed);
    die();
}

// Convert
$converted = UnitConverterHelper::convert($from, $to, $value, $type);

// Error in convert
if (!$converted['success']) {
    JsonResponser::error([], $messageData['error']['unit_converter'][$converted['message']], 500, $languageUsed);
    die();
}


// TODO: For future updates: Add a render template option
header('Content-Type: application/json; charset=utf-8');

JsonResponser::success($converted['value'], $messageData['success']['general']['data_retrieved'], 200, $languageUsed);