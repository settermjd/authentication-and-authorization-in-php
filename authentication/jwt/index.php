<?php
declare(strict_types=1);

use Firebase\JWT\JWT;

require_once __DIR__ . "/../../vendor/autoload.php";

if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    header('Location: /login.php');
    exit;
} else {
    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }

    $retrievedToken = $matches[1];
    $issuer = 'https://localdomain.dev';
    $key = 'XicRF1ZLIUc+NzB4uqdaVlyVNSucfR90kmoAiuOGRi0=';

    $token = JWT::decode($retrievedToken, $key, ['HS256']);
    $now = new DateTimeImmutable();

    // Determine if the token is valid or not
    if ($token->iss !== $issuer ||
        $token->nbf < $now->getTimestamp() ||
        $token->exp > $now->getTimestamp())
    {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
}