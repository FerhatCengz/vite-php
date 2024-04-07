<?php
header("Access-Control-Allow-Origin: *");
class JWTVerifier
{
    private static $key = "cengizcengizcengizcengiz";

    public static function verifyToken($jwt)
    {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        // Check the expiration time - note this will cause an error if not set
        $expiration = json_decode($payload)->exp;
        $isTokenExpired = ($expiration - time()) < 0;

        // Build a signature based on the header and payload using the secret
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Verify it matches the signature provided in the token
        $isSignatureValid = ($base64UrlSignature === $signatureProvided);

        return !$isTokenExpired && $isSignatureValid;
    }
}




if (isset($_REQUEST['token'])) {
        $jwt = $_REQUEST['token'];
        $isValid = JWTVerifier::verifyToken($jwt);

        if ($isValid) {
            // echo 'Token is valid';
            // Kodlar derlenir..

        } else {
            echo 'Invalid token';
            exit();
        }
    } else {
        echo 'No token found in request';
        exit();
}



/*

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['token'])) {
        $jwt = $_GET['token'];
        $isValid = JWTVerifier::verifyToken($jwt);

        if ($isValid) {
            // echo 'Token is valid';
            // Kodlar derlenir..

        } else {
            echo 'Invalid token';
            exit();
        }
    } else {
        echo 'No token found in request';
        exit();
    }
} else {
    echo 'Invalid request method';
    exit();
}
*/
