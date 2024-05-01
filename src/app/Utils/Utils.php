<?php

namespace App\Utils;

class Utils {

    /**
     * Mounts a path from an array of strings
     *
     * @param array $path
     * @return string
     */
    public static function mountPath($path) {
        return join(DIRECTORY_SEPARATOR, $path);
    }
}