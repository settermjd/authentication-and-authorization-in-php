<?php

/**
 * Parse the http auth header
 * @param string $authHeader The 'Authorization' header sent by the client
 * @return array|false
 */
function httpDigestParse(string $authHeader)
{
    $needed_parts = [
        'cnonce' => 1,
        'nc' => 1,
        'nonce' => 1,
        'qop' => 1,
        'response' => 1,
        'uri' => 1,
        'username' => 1,
    ];
    $data = [];
    $keys = implode('|', array_keys($needed_parts));
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $authHeader, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

function generateValidResponse(array $data, string $realm, string $users): string
{
    $A1 = md5(sprintf('%s:%s:%s', $data['username'], $realm, $users));
    $A2 = md5(sprintf('%s:%s', $_SERVER['REQUEST_METHOD'], $data['uri']));
    return md5(sprintf('%s:%s:%s:%s:%s:%s', $A1, $data['nonce'], $data['nc'], $data['cnonce'], $data['qop'], $A2));
}

$realm = 'Restricted area';
$users = [
    'admin' => 'mypass',
    'guest' => 'guest'
];

if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header(
        sprintf(
            'WWW-Authenticate: Digest realm="%s",qop="auth",nonce="%s",opaque="%s"',
            $realm,
            uniqid(),
            md5($realm)
        )
    );

    die('Text to send if user hits Cancel button');
}

$data = httpDigestParse($_SERVER['PHP_AUTH_DIGEST']);
if ($data === FALSE || !isset($users[$data['username']])) {
    die('Wrong Credentials!');
}

$valid_response = generateValidResponse($data, $realm, $users[$data['username']]);
if ($data['response'] != $valid_response){
    die('Wrong Credentials!');
}

// ok, valid username & password
printf("You are logged in as: %s", $data['username']);
