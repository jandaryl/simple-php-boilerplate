<?php
require_once 'app/backend/core/Init.php';

if (! $user->isLoggedIn())
{
     Redirect::to('index.php');
}

$data = $user->data();


