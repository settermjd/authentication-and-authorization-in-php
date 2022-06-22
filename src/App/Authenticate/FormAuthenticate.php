<?php
declare(strict_types=1);

namespace App\Authenticate;

class FormAuthenticate
{
    public static function isLoggedIn(): bool
    {
        return (! empty($_SESSION['identity']));
    }

    public static function generateCSRFToken()
    {
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    public static function login(): array
    {
        $errors = [];

        if (empty($_POST['username'])) {
            $errors['username'] = 'Username is missing';
        }

        if (empty($_POST['password'])) {
            $errors['password'] = 'password is missing';
        }

        if (empty($_POST['__csrf'])) {
            $errors['__csrf'] = 'CSRF token is missing';
        }

        if (! hash_equals($_SESSION['token'], $_POST['__csrf'])) {
            $errors['__csrf'] = 'CSRF token is invalid';
        }

        // Update the current session id with a newly generated one
        session_regenerate_id(true);

        return $errors;
    }

    public static function getFormFieldValue(string $fieldName): string
    {
        return (! empty($_POST[$fieldName])) ? $_POST[$fieldName] : '';
    }

    public static function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }
}