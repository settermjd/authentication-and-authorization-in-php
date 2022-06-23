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
        header('Location: /authentication/form-based/');
    }

    // Now check if we have a valid user or not...
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
<form method="POST" action="/authentication/form-based/login.php">
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
