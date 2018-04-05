<?php
include_once __DIR__ . '/helperFunctions.php';

$jwt = isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : null;

$response = executeCurl('http://localhost.searchLocation.com/API/index.php?apiName=checkJWT', [], ["jwt:$jwt"]);

$isValidJWT = isset($response['validJWT']) ? $response['validJWT'] : false;

if (!$isValidJWT) {
    header('Location: /');
}
