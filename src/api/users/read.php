<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Models\UserModel;
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

        $id = isset($queryData["id"]) ? $queryData["id"] : 0;
        $name = isset($queryData["name"]) ? $queryData["name"] : null;
        $email = isset($queryData["email"]) ? $queryData["email"] : null;
        $limit = isset($queryData["limit"]) ? $queryData["limit"] : 1;
    } else {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $id = isset($body["id"]) ? $body["id"] : 0;
        $name = isset($body["name"]) ? $body["name"] : null;
        $email = isset($body["email"]) ? $body["email"] : null;
        $limit = isset($body["limit"]) ? $body["limit"] : 1;
    }
} else {
    // Get via $_GET
    $renderTemplate = true;

    $id = isset($_GET["id"]) ? $_GET["id"] : 0;
    $name = isset($_GET["name"]) ? $_GET["name"] : null;
    $email = isset($_GET["email"]) ? $_GET["email"] : null;
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 1;
}

// Request doen't have authorization header
if (empty($authorization)) {
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$authorization = str_replace('Bearer ', '', $authorization);

// Check token
$tokenModel = new TokenModel();
$userModel = new UserModel();

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

$tokenData = $token['data'][0];

$user = $userModel->get($tokenData['user_id']);

// Error in get user. Server side
if (!$user['success']) {
    JsonResponser::error([], $messageData['error']['general']['fail_retrieving_data'], 500, $languageUsed);
    die();
}

// User not found. Need to login again
if (empty($user['data'])) {
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$user = $user['data'][0];

$conditions = [];

if(!empty($name)){
    $conditions[] = [
        'key' => 'name',
        'operator' => 'LIKE',
        'value' => '%' . $name . '%'
    ];
}

if(!empty($email)){
    $conditions[] = [
        'key' => 'email',
        'operator' => 'LIKE',
        'value' => '%' . $email . '%'
    ];
}

$result = $userModel->get(
    $id,
    $limit,
    'id',
    'ASC',
    [
        'id',
        'name',
        'email',
        'is_activated',
    ],
    $conditions
);


if (!$result['success']) {
    // Error updateing user
    JsonResponser::error([], $result['message'], 500, $languageUsed);
    die();
}

if ($renderTemplate) {
    // Render template
    $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'userDeleted.php');

    echo $template;
} else {
    // Return json
    header('Content-Type: application/json; charset=utf-8');

    JsonResponser::success($result['data'], $messageData['success']['general']['data_retrieved'], 200, $languageUsed);
}
