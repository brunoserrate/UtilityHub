<?php


require_once  __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, ['..', 'autoloader.php']);

use App\Utils\Database\Database;


$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "Connected to the database";
} else {
    echo "Failed to connect to the database";
}