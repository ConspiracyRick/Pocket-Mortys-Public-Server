<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");


http_response_code(400);
$error = json_encode([
    "error" => [
        "code" => "NO_REWARDS_PENDING"
    ]
], JSON_UNESCAPED_SLASHES);
echo $error;
exit;