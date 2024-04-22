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

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    JsonResponser::error([], $messageData['error']['general']['method_not_allowed'], 405, $languageUsed);
    die();
}

$renderTemplate = false;
$headers = apache_request_headers();
$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : null;

// Get the post data
if (!isset($_SESSION["requested_via_browser"]) || !$_SESSION["requested_via_browser"]) {
    // Get via file content (body) instead of $_POST
    $body = file_get_contents('php://input');
    $body = json_decode($body, true);

    $id = isset($body["id"]) ? $body["id"] : null;
} else {
    // Get via $_POST
    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $renderTemplate = true;
}

// Request doen't have authorization header
if(empty($authorization)){
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

if(empty($id)){
    JsonResponser::error([], $messageData['error']['general']['parameters_empty'], 400, $languageUsed);
    die();
}

$authorization = str_replace('Bearer ', '', $authorization);

// Check token
$tokenModel = new TokenModel();
$userModel = new UserModel();

$token = $tokenModel->get(
    0,1,'id','DESC',
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
if(!$token['success']){
    JsonResponser::error([], $messageData['error']['general']['fail_retrieving_data'], 500, $languageUsed);
    die();
}

// Token not found. Need to login again
if(empty($token['data'])){
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$tokenData = $token['data'][0];

$user = $userModel->get($tokenData['user_id']);

// Error in get user. Server side
if(!$user['success']){
    JsonResponser::error([], $messageData['error']['general']['fail_retrieving_data'], 500, $languageUsed);
    die();
}

// User not found. Need to login again
if(empty($user['data'])){
    JsonResponser::error([], $messageData['error']['token']['token_not_found'], 404, $languageUsed);
    die();
}

$user = $user['data'][0];

$result = $userModel->delete($id, [], true);

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


    JsonResponser::success([], $messageData['success']['users']['user_desactivated'], 200, $languageUsed);
}
