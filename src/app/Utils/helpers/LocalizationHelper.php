<?php

namespace App\Utils\Helpers;

use App\Utils\Helpers\EnvLoader;

class LocalizationHelper
{

    public static function getLanguage($accept_language = null)
    {
        $language = 'en';
        $languagePath = ROOT_PATH . DIRECTORY_SEPARATOR . EnvLoader::loadEnv()['LANGUAGES_PATH'];
        $languageList = [];

        if (!isset($accept_language) || $accept_language == null) {
            return $language;
        }

        if ($handle = opendir($languagePath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") continue;
                if (strpos($entry, '.php') === false) continue;

                $languageList[] = substr($entry, 0, -4);
            }
        }

        if (count($languageList) == 0) return $language;

        $userLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $userPreferredLanguage = $userLanguages[0];

        if (in_array($userPreferredLanguage, $languageList)) {
            $language = $userPreferredLanguage;
        }

        return $language;
    }

    public static function getLanguagePath()
    {
        return ROOT_PATH . DIRECTORY_SEPARATOR . EnvLoader::loadEnv()['LANGUAGES_PATH'] . DIRECTORY_SEPARATOR;
    }
}
