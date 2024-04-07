<?php
header("Access-Control-Allow-Origin: *");

$key = "cengizcengizcengizcengiz";
$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
$payload = json_encode([
    'iss' => 'localhost',
    'aud' => 'localhost',
    'users' => [
        'adi' => 'Ferhat',
        'role' => 'Admin'
    ],
    'iat' => time(),
    'exp' => time() + (10 * 60) // 10 dakika
]);

$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

echo $jwt;
