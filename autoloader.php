<?php

$rootPath = __DIR__;
define("ROOT_PATH", $rootPath);

spl_autoload_register(
    function ($class_name) use ($rootPath) {
        $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);

        $paths = explode(DIRECTORY_SEPARATOR, $class_name);
        $classToImport = '';

        for ($i = 0; $i < count($paths); $i++) {
            if ($i < count($paths) - 1) {
                $paths[$i] = strtolower($paths[$i]) . DIRECTORY_SEPARATOR;
            }

            $classToImport .= $paths[$i];
        }


        $filePath = $rootPath . DIRECTORY_SEPARATOR . $classToImport . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
);