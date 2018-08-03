<?php
session_start();

require_once 'app/backend/auth/config.php';
require_once 'app/backend/core/Helpers.php';

spl_autoload_register("autoload");

require_once 'app/backend/auth/cookie.php';
require_once 'app/backend/auth/user.php';







