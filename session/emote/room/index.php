<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $data['session_id'];
$emote = $data['emote'];

// output the response
echo json_encode(
    ["success" => true],
    JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
);
echo $response;
exit;