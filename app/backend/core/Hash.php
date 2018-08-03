<?php

class Hash
{
    public static function make($string)
    {
        return hash(Config::get('hash/algo_name'), $string . Hash::salt());
    }

    public static function salt()
    {
        return mcrypt_create_iv(Config::get('hash/salt'));
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}
