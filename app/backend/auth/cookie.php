<?php
require_once 'app/backend/core/Init.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
{
    $hash       = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck  = Database::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count())
    {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
