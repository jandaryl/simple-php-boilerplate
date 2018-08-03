<?php
require_once 'app/backend/core/Init.php';

$user->deleteMe();

Redirect::to('index.php');
