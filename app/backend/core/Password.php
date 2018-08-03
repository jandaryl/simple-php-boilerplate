<?php

class Password
{
    public static function hash($password)
    {
       return password_hash($password, Config::get('password/algo_name'),
            array(
                'cost' => Config::get('password/cost'),
                'salt' => Hash::salt()
            ));
    }

    public static function rehash($hash)
    {
        return password_rehash($hash, Config::get('password/algo_name'), Config::get('password/cost'));
    }

    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function getInfo($hash)
    {
        return password_get_info($hash);
    }

}
