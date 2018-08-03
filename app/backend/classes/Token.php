<?php

class Token
{
    public static function generate()
    {
        return Session::put(Config::get('session/token_name'), Hash::make(uniqid()));
    }

    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');

        if(Session::exists($tokenName) && $token === Session::get($tokenName))
        {
            return true;
        }

        return false;
    }
}
