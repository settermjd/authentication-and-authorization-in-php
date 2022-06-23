<?php

$username = 'admin';
$password = 'passw0rd';

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Parcel Tracker API"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must provide a valid username and password to access the service\n";
    exit;
}

// Reject users with invalid credentials
if ($_SERVER['PHP_AUTH_USER'] !== $username ||
    $_SERVER['PHP_AUTH_PW'] !== $password) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Either your username or password was not valid\n";
}

// ... Show the page
echo "Hello world!";