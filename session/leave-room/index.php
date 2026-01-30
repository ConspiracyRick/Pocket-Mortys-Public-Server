<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

require __DIR__ . "/../../pocket_f4894h398r8h9w9er8he98he.php";
require_once __DIR__ . "/../../lib/auth.php";
require_once __DIR__ . "/../../lib/events.php";

$body = json_decode(file_get_contents("php://input"), true) ?: [];
$session_id = (string)($body["session_id"] ?? "");

if ($session_id === "") {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Missing session_id"], JSON_UNESCAPED_SLASHES);
    exit;
}

// ✅ Must be authenticated to leave
$user = require_user_by_session($pdo, $session_id);
$player_id = (string)$user["player_id"];

// Find which room they are currently in
$stmt = $pdo->prepare("SELECT room_id FROM room_presence WHERE player_id = ? LIMIT 1");
$stmt->execute([$player_id]);
$room_id = $stmt->fetchColumn();

if (!$room_id) {
    // Not in any room — nothing to remove
    echo json_encode(["success" => true, "left" => false], JSON_UNESCAPED_SLASHES);
    exit;
}

// ✅ Remove them from presence (this stops “ghost players”)
$del = $pdo->prepare("DELETE FROM room_presence WHERE player_id = ? LIMIT 1");
$del->execute([$player_id]);

// ✅ Also clear stream cursor for that room (optional but recommended)
$cur = $pdo->prepare("DELETE FROM room_stream_cursor WHERE player_id = ? AND room_id = ? LIMIT 1");
$cur->execute([$player_id, $room_id]);

// ✅ Broadcast leave to everyone still in that room
publish_event($pdo, (string)$room_id, "room:user-removed", [
    "player_id" => $player_id
]);

echo json_encode([
    "success" => true
], JSON_UNESCAPED_SLASHES);
