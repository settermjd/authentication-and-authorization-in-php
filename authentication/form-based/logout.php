<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Authenticate\FormAuthenticate as Authenticate;

session_start();

Authenticate::logout();
header('Location: /authentication/form-based/');