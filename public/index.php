<?php
define("ROOT_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." );

require join(DIRECTORY_SEPARATOR, [__DIR__, '..','vendor' ,'autoload.php']);

require join(DIRECTORY_SEPARATOR, [__DIR__,'..','src','app','Utils','global_functions.php']);

use App\Utils\Helpers\EnvLoader;

define("ENV", EnvLoader::loadEnv());

$router = require join(DIRECTORY_SEPARATOR, [__DIR__,'..','src','app','Routes','index.php']);