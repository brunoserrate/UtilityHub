<?php

namespace App\Interfaces;

interface ConverterInterface {

    public function convert($from, $to, $value);

}