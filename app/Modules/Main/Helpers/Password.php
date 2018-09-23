<?php

namespace Modules\Main\Helpers;


class Password
{
    public static function hash($raw, $algo = PASSWORD_DEFAULT, $options = [])
    {
        return password_hash($raw, $algo, $options);
    }

    public static function verify($raw, $hashed)
    {
        return password_verify($raw, $hashed);
    }
}