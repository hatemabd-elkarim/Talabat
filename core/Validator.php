<?php

namespace Core;

class Validator
{
    public static function string($value, $min = 8, $max = INF)
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) < $max;
    }

    public static function email($value)
    {
        $value = trim($value);

        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
