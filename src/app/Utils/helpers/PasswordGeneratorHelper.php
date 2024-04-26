<?php

namespace App\Utils\Helpers;

class PasswordGeneratorHelper
{
    private $chars = [
        'lowercase' => 'abcdefghijklmnopqrstuvwxyz',
        'uppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'numbers' => '0123456789',
        'symbols' => '!@#$%^&*()_-=+;:,.?'
    ];

    public function getCharacters()
    {
        return $this->chars;
    }

    public function generatePassword($length, $samples = 1, $useLowerCase = true, $useUpperCase = true, $useNumbers = true, $useSymbols = false, $useSimilarCharacters = false, $uniqueCharacters = false)
    {

        $passwords = [];

        for ($i = 0; $i < $samples; $i++) {

            $password = '';

            $chars = [];

            if ($useLowerCase) {
                $chars[] = $this->chars['lowercase'];
            }

            if ($useUpperCase) {
                $chars[] = $this->chars['uppercase'];
            }

            if ($useNumbers) {
                $chars[] = $this->chars['numbers'];
            }

            if ($useSymbols) {
                $chars[] = $this->chars['symbols'];
            }

            $chars = implode($chars);

            $charsLength = strlen($chars);


            for ($j = 0; $j < $length; $j++) {
                $password .= $chars[rand(0, $charsLength - 1)];
            }

            if ($useSimilarCharacters) {
                $similarCharacters = [
                    'i' => ['1', '!', '|'],
                    'o' => ['0'],
                    'O' => ['0'],
                    's' => ['5', '$'],
                    'S' => ['5', '$'],
                    'a' => ['@'],
                    'A' => ['@'],
                    'e' => ['3'],
                    'E' => ['3'],
                    'b' => ['8'],
                    'B' => ['8'],
                ];

                foreach ($similarCharacters as $key => $value) {
                    if (strpos($password, $key) !== false) {
                        $password = str_replace($key, $value[array_rand($value)], $password);
                    }
                }
            }

            if ($uniqueCharacters) {
                $password = str_shuffle($password);
            }

            $passwords[] = $password;
        }

        return $passwords;
    }
}
