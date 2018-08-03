<?php
require_once 'app/backend/core/Init.php';

$user->logout();

Redirect::to('index.php');
