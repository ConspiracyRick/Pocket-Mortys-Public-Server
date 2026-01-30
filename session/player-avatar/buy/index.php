<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $data['session_id'];
$player_avatar_id = $data['player_avatar_id'];

require '../../../pocket_f4894h398r8h9w9er8he98he.php';

// output the response
$response = json_encode([
    "coins" => 3205915,
    "coins_deducted" => 0,
    "result" => [
        "type" => "AVATAR",
        "player_avatar_id" => $player_avatar_id
    ]
], JSON_UNESCAPED_SLASHES);
echo $response;
exit;