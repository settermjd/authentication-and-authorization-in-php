<?php
declare(strict_types=1);

use App\Authenticate\FormAuthenticate as Authenticate;
use Firebase\JWT\JWT;

require_once __DIR__ . "/../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = Authenticate::login();
    if (empty($errors)) {
        $issuer = 'https://localdomain.dev';
        $key = 'XicRF1ZLIUc+NzB4uqdaVlyVNSucfR90kmoAiuOGRi0=';
        $now = new DateTimeImmutable();
        $expiry = $now->modify('+20 minutes')->getTimestamp();
        $payload = array(
            "iss" => $issuer,
            "aud" => $issuer,
            "iat" => $now->getTimestamp(),
            "nbf" => $now->modify('+1 minute')->getTimestamp(),
            "sub" => Authenticate::getFormFieldValue('username'),
            "exp" => $expiry
        );
        echo JWT::encode($payload, $key,"HS256");
        exit;
    }
}