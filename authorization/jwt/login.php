<?php
declare(strict_types=1);

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Authenticate\FormAuthenticate as Authenticate;
use Firebase\JWT\JWT;

session_start();

Authenticate::generateCSRFToken();

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parcel Tracker</title>
</head>
<body>
<?php
if (!empty($errors)) {
    echo "<strong>Form Errors</strong>";
    echo "<p>There were some issues with validating the form:</p>";
    echo "<ul>";
    foreach ($errors as $field => $error) {
        printf("<li>Field: %s. Reason: %s</li>", $field, $error);
    }
    echo "</ul>";
}
?>
<form method="POST" action="/authorization/jwt/login.php">
    <label>username:
        <input type="text" name="username"
               value="<?php echo Authenticate::getFormFieldValue('username') ?>"
        ></label>
    <label>password:
        <input type="password" name="password" value=""></label>
    <input name="__csrf" type="hidden" value="<?php echo $_SESSION['token']; ?>"/>
    <button type="submit">Login</button>
</form>
</body>
</html>
