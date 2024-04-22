<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoloader.php';

use App\Utils\Helpers\JsonResponser;
use App\Utils\Helpers\LocalizationHelper;
use App\Models\UserModel;

$acceptLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
$languageUsed = LocalizationHelper::getLanguage($acceptLanguage);
$messageData = include (LocalizationHelper::getLanguagePath() . $languageUsed) . ".php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    JsonResponser::error([], $messageData['error']['general']['method_not_allowed'], 405, $languageUsed);
    die();
}

$renderTemplate = false;

// Get the post data
if (!isset($_SESSION["requested_via_browser"]) || !$_SESSION["requested_via_browser"]) {
    // Get via file content (body) instead of $_POST
    $body = file_get_contents('php://input');
    $body = json_decode($body, true);

    $name = isset($body["name"]) ? $body["name"] : null;
    $email = isset($body["email"]) ? $body["email"] : null;
    $password = isset($body["password"]) ? $body["password"] : null;
    $confirm_password = isset($body["confirm_password"]) ? $body["confirm_password"] : null;
} else {
    // Get via $_POST
    $name = isset($_POST["name"]) ? $_POST["name"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : null;

    $renderTemplate = true;
}

// Check values
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    // Invalid values
    JsonResponser::error([], $messageData['error']['users']['users_empty'], 400, $languageUsed);
    die();
}

if ($password !== $confirm_password) {
    // Passwords don't match
    JsonResponser::error([], $messageData['error']['users']['users_passwords_dont_match'], 400, $languageUsed);
    die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email
    JsonResponser::error([], $messageData['error']['users']['users_invalid_email'], 400, $languageUsed);
    die();
}

$userModel = new UserModel();

$newUser = $userModel->insert(
    [
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]
);

if (!$newUser['success']) {
    // Error creating user
    JsonResponser::error([], $newUser['message'], 500, $languageUsed);
    die();
}


if ($renderTemplate) {
    // Render template
    $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'userRegistered.php');

    echo $template;
} else {
    // Return json
    header('Content-Type: application/json; charset=utf-8');

    JsonResponser::success([
        'id' => $newUser['data']['id']
    ], $messageData['success']['users']['user_registered'], 200, $languageUsed);
}
