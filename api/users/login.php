<?php
session_start();

require_once join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'autoloader.php']);

use App\Utils\Utils;
use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Models\UserModel;
use App\Models\TokenModel;

$acceptLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
$languageUsed = LocalizationHelper::getLanguage($acceptLanguage);
$messageData = include (LocalizationHelper::getLanguagePath() . $languageUsed) . ".php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    JsonResponser::error([], $messageData['error']['general']['method_not_allowed'], 405, $languageUsed);
    die();
}

$renderTemplate = false;

// Get the post data
if(!isset($_SESSION["requested_via_browser"]) || !$_SESSION["requested_via_browser"]){
    // Get via file content (body) instead of $_POST
    $body = file_get_contents('php://input');
    $body = json_decode($body, true);

    $email = isset($body["email"]) ? $body["email"] : null;
    $password = isset($body["password"]) ? $body["password"] : null;
}
else {
    // Get via $_POST
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;

    $renderTemplate = true;
}

// Check values
if(empty($email) || empty($password)){
    // Invalid values
    JsonResponser::error([], $messageData['error']['users']['users_empty'], 400, $languageUsed);
    die();
}

$userModel = new UserModel();
$tokenModel = new TokenModel();

// Check if user exists
$user = $userModel->get(
    0,
    1,
    'id',
    'DESC',
    [
        'id',
        'name',
        'email',
        'password',
        'is_activated',
    ],
    [
        [
            'key' => 'email',
            'operator' => '=',
            'value' => $email
        ]
    ]
);

if(empty($user)){
    // User not found
    JsonResponser::error([], $messageData['error']['users']['users_not_found'], 404, $languageUsed);
    die();
}

if(count($user['data']) < 1){
    // More than one user found
    JsonResponser::error([], $messageData['error']['users']['users_not_found'], 404, $languageUsed);
    die();
}

$user = $user['data'][0];

// Check if user is activated
if(!$user['is_activated']){
    // User not activated
    JsonResponser::error([], $messageData['error']['users']['users_not_activated'], 403, $languageUsed);
    die();
}

// Check if password is correct
if(!password_verify($password, $user['password'])){
    // Password incorrect
    JsonResponser::error([], $messageData['error']['users']['users_password_incorrect'], 400, $languageUsed);
    die();
}

// Generate token
$token = $tokenModel->generateToken($user['id']);

if(empty($token)){
    // Token not generated
    JsonResponser::error([], $messageData['error']['users']['users_token_not_generated'], 500, $languageUsed);
    die();
}

if($renderTemplate){
    // Render template
    $template = file_get_contents( Utils::mountPath([__DIR__,'..','..','app','view','userLoged.php']) );
    $template = str_replace('{%token%}', $token, $template);

    echo $template;
}
else {
    // Return json
    header('Content-Type: application/json; charset=utf-8');

    JsonResponser::success([
        'token' => $token
    ], $messageData['success']['users']['users_logged_in'], 200, $languageUsed);
}