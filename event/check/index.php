<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

require __DIR__ . "/../../pocket_f4894h398r8h9w9er8he98he.php";
require_once __DIR__ . "/../../lib/events.php";

$REQUIRE_SECRET = false;
$EVENT_SECRET   = "change_me_to_a_long_random_string";

if ($REQUIRE_SECRET) {
    $hdr = $_SERVER['HTTP_X_EVENT_SECRET'] ?? '';
    if (!hash_equals($EVENT_SECRET, $hdr)) {
        http_response_code(403);
        echo json_encode(["success" => false, "error" => "Forbidden"]);
        exit;
    }
}

// Read body
$raw  = file_get_contents("php://input");
$body = json_decode($raw, true);

// Allow quick GET testing as a fallback
if (!is_array($body)) $body = [];
$room_id = (string)($body["room_id"] ?? ($_GET["room_id"] ?? ""));

// If you don’t pass a room_id, default to your main room
if ($room_id === "") {
    $room_id = "76092cc3-d968-4d2d-8c54-98ed0817bc5a";
}

// You can also pass world_id or anything else you want
$world_id = (int)($body["world_id"] ?? ($_GET["world_id"] ?? 1));

// Build the raid state payload (exact shape you posted)
$payload = [
    "raid_event_id" => (string)($body["raid_event_id"] ?? "RaidBossKillerAsteroid_2025"),
    "shard_id" => (string)($body["shard_id"] ?? "78496e72-fb88-11f0-b2fd-8b24d97da62f"),
    "current_state" => (string)($body["current_state"] ?? "build_up"),
    "world_id" => $world_id,
    "spawn_location" => (string)($body["spawn_location"] ?? "37,58"),
    "boss_id" => (string)($body["boss_id"] ?? "killer_asteroid"),
    "asset_id" => (string)($body["asset_id"] ?? "RaidBossKillerAsteroid"),
    "threat_lvl" => (int)($body["threat_lvl"] ?? 10),
    "total_damage" => (string)($body["total_damage"] ?? "0"),
    "initial_health" => (int)($body["initial_health"] ?? 30860800),
    "max_health_bars" => (int)($body["max_health_bars"] ?? 60275),
    "event_state_next_timestamp" => (string)($body["event_state_next_timestamp"] ?? "2026-01-30T14:00:00.000Z"),
    "has_ran" => (bool)($body["has_ran"] ?? false),
    "permit_start" => (int)($body["permit_start"] ?? 50),
    "permit_buy_in" => (int)($body["permit_buy_in"] ?? 1),
    "ticket_buy_in" => (int)($body["ticket_buy_in"] ?? 0),
];

// Publish into the room stream (SSE clients will receive it)
publish_event($pdo, $room_id, "shard:raid-boss-state-changed", $payload);

echo json_encode([
    "success" => true
], JSON_UNESCAPED_SLASHES);
