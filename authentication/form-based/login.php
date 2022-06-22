<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Authenticate\FormAuthenticate as Authenticate;

session_start();

Authenticate::generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = Authenticate::login();
    if (empty($errors)) {
        // Update the current session id with a newly generated one
        session_regenerate_id(true);
        $_SESSION['identity'] = Authenticate::getFormFieldValue('username');
        header('Location: /');
    }

    // Now check if we have a valid user or not...
}