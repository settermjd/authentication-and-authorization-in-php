<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Authenticate\FormAuthenticate as Authenticate;

session_start();

if (! Authenticate::isLoggedIn()) {
    header("Location: /login.php");
    exit;
}