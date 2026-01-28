<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

require '../../../pocket_f4894h398r8h9w9er8he98he.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$session_id = $data['session_id'];

if (empty($session_id)) {
    die("Not authenticated");
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE session_id = ?");
$stmt->execute([$session_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$player_id = $user['player_id'];

echo '1';
