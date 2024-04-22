<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Utils\Helpers\RandomNumberHelper;
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

        $min = isset($queryData['min']) ? $queryData['min'] : 1;
        $max = isset($queryData['max']) ? $queryData['max'] : 100;
        $samples = isset($queryData['samples']) ? $queryData['samples'] : 1;
        $unique = isset($queryData['unique']) ? $queryData['unique'] : false;
    } else {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $min = isset($body['min']) ? $body['min'] : 1;
        $max = isset($body['max']) ? $body['max'] : 100;
        $samples = isset($body['samples']) ? $body['samples'] : 1;
        $unique = isset($body['unique']) ? $body['unique'] : false;
    }
} else {
    // Get via $_GET
    $renderTemplate = true;

    $min = isset($_GET['min']) ? $_GET['min'] : 1;
    $max = isset($_GET['max']) ? $_GET['max'] : 100;
    $samples = isset($_GET['samples']) ? $_GET['samples'] : 1;
    $unique = isset($_GET['unique']) ? $_GET['unique'] : false;
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

$numbers = RandomNumberHelper::generate(
    $min,
    $max,
    $samples,
    $unique
);

$statistic = RandomNumberHelper::generateStatistic($numbers);

foreach ($statistic as $key => $value) {

    if($messageData['return_keys']['random_numbers'][$key] == $key) continue;

    $statistic[
        $messageData['return_keys']['random_numbers'][$key]
    ] = $statistic[$key];

    unset($statistic[$key]);
}

// TODO: For future updates: Add a render template option
header('Content-Type: application/json; charset=utf-8');

JsonResponser::success([
    $messageData['return_keys']['random_numbers']['numbers'] => $numbers,
    $messageData['return_keys']['random_numbers']['statistic'] => $statistic
], $messageData['success']['general']['data_retrieved'], 200, $languageUsed);
