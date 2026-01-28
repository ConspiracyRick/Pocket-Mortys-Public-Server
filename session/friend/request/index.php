<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

require '../../../pocket_f4894h398r8h9w9er8he98he.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $data['session_id'];
$request_sent_player_id = $data['player_id'];

if (empty($session_id)) {
    die("Not authenticated");
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE session_id = ?");
$stmt->execute([$session_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Not authenticated");
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE player_id = ?");
$stmt->execute([$request_sent_player_id]);
$other_user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$other_user) {
    die("Not authenticated");
}

$player_id = $user['player_id'];
$wins_b = $user['wins'];
$request_sent_player_id = $other_user['player_id'];
$wins_a = $other_user['wins'];
$date = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d\TH:i:s.v') . 'Z';

/*
status: 400
{
	"error": {
		"code": "FRIEND_LIMIT_OTHER"
	}
}

// already friends and a sent request.
{
	"error": {
		"code": "FRIEND_DUPLICATE"
	}
}
*/

$stmt = $pdo->prepare("SELECT * FROM friend_list WHERE player_id_a = ? AND player_id_b = ?");
$stmt->execute([$request_sent_player_id, $player_id]);
$find = $stmt->fetch(PDO::FETCH_ASSOC);

if($find){
http_response_code(400);
$error = json_encode([
    "error" => [
        "code" => "FRIEND_DUPLICATE"
    ]
], JSON_UNESCAPED_SLASHES);
echo $error;
}
if(!$find){
$stmt_1 = $pdo->prepare("
INSERT INTO friend_list (player_id_a, player_id_b, pending, direction, created, modified)
VALUES (?, ?, ?, ?, ?, ?)
");
$stmt_1->execute([$request_sent_player_id, $player_id, 'true', 'false', $date, $date]);

$response = json_encode([
    "player_id_a" => $request_sent_player_id,
    "player_id_b" => $player_id,
    "wins_a" => $wins_a,
    "wins_b" => $wins_b,
	"pending" => true,
	"direction" => false,
	"_created" => $date,
	"_modified" => $date,
], JSON_UNESCAPED_SLASHES);

$etag = 'W/"' . md5($response) . '"';
header("ETag: $etag");
echo $response;
}