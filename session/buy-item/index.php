<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $data['session_id'];
$item_id = $data['item_id'];

require '../../pocket_f4894h398r8h9w9er8he98he.php';

// output the response
$response = json_encode([
    "coins" => 3205915,
    "coupons" => 1,
    "result" => [
        "type" => "ITEM",
        "item_id" => $item_id,
        "quantity" => 1,
        "amount_received" => 1,
        "amount" => 1
    ]
], JSON_UNESCAPED_SLASHES);
echo $response;
exit;