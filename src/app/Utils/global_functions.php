<?php

function getBrowserLanguage() {
    $lang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0];
    return $lang;
}

/**
 * Function to translate strings
 *
 * CakePHP like function to translate strings
 *
 * @param string $key
 * @return string
 */
function __(string $key) {
    $lang = getBrowserLanguage();
    $path = join(DIRECTORY_SEPARATOR, [ROOT_PATH, 'src', 'resources', 'lang', $lang . '.php']);
    $translations = require $path;
    return $translations[$key] ?? $key;
}
