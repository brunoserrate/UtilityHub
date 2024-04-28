<?php

namespace App\Utils\Helpers;

define("ENV_FILE", ROOT_PATH . DIRECTORY_SEPARATOR . '.env');
define("ALTERNATIVE_ENV", ROOT_PATH . DIRECTORY_SEPARATOR . 'env');
class EnvLoader
{

    public static function loadEnv()
    {
        $envData = [];
        $env = null;

        if (file_exists(ENV_FILE)) {
            $env = fopen(ENV_FILE, "r");
        } else if (file_exists(ALTERNATIVE_ENV)) {
            $env = fopen(ALTERNATIVE_ENV, "r");
        } else {
            return $envData;
        }

        while (!feof($env)) {
            $line = fgets($env);
            $line = explode('=', $line);

            if (count($line) < 2 || count($line) > 3) continue;
            if (empty($line[0])) continue;

            $envData[$line[0]] = trim(str_replace("\"", '', $line[1]));
        }
        return $envData;
    }

    public static function getEnv($key)
    {
        $env = self::loadEnv();
        return $env[$key];
    }
}
