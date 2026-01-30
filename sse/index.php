<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

set_time_limit(0);
ignore_user_abort(true);

header('Content-Type: text/event-stream; charset=utf-8');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

require __DIR__ . "/../pocket_f4894h398r8h9w9er8he98he.php";
require __DIR__ . "/../lib/auth.php";
require __DIR__ . "/../lib/events.php";

function base64url_decode($data) { return base64_decode(strtr($data, '-_', '+/')); }
function decode_jwt_payload($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) < 2) return null;
    return json_decode(base64url_decode($parts[1]), true);
}
function payload_player_id($json) {
    $d = json_decode($json, true);
    return (is_array($d) && isset($d["player_id"])) ? (string)$d["player_id"] : null;
}
function cursor_get(PDO $pdo, string $player_id, string $room_id): ?int {
    $q = $pdo->prepare("SELECT last_event_id FROM room_stream_cursor WHERE player_id = ? AND room_id = ? LIMIT 1");
    $q->execute([$player_id, $room_id]);
    $v = $q->fetchColumn();
    return ($v === false || $v === null) ? null : (int)$v;
}
function cursor_set(PDO $pdo, string $player_id, string $room_id, int $last_id): void {
    $q = $pdo->prepare("
      INSERT INTO room_stream_cursor (player_id, room_id, last_event_id)
      VALUES (?, ?, ?)
      ON DUPLICATE KEY UPDATE last_event_id = VALUES(last_event_id), updated_at = NOW()
    ");
    $q->execute([$player_id, $room_id, $last_id]);
}

// --- auth ---
$token = $_GET['token'] ?? null;
$profile = $token ? decode_jwt_payload($token) : null;

$session_id = $profile['session_id'] ?? "";
if ($session_id === "") {
    http_response_code(400);
    echo "event: error\n";
    echo "data: " . json_encode(["error"=>"Missing session_id"], JSON_UNESCAPED_SLASHES) . "\n\n";
    @ob_flush(); @flush();
    exit;
}

$user = require_user_by_session($pdo, $session_id);
$player_id = (string)$user["player_id"];

$tags = $user["tags"] ?? [];
if (is_string($tags)) {
    $decoded = json_decode($tags, true);
    $tags = is_array($decoded) ? $decoded : [];
} elseif (!is_array($tags)) {
    $tags = [];
}

$ping_url = $profile['ping_url'] ?? "https://pocketmortys.conspiracyrick.com/session/ping-dynamic";

$session = [
    "player_id" => $player_id,
    "session_id" => $session_id,
    "username" => (string)$user["username"],
    "level" => (int)$user["level"],
    "tags" => $tags,
    "ping_interval" => 30,
    "ping_url" => $ping_url,
    "keep_alive" => 30,
    "server_instance" => "/ip-10-100-0-46/1/1143",
    "worlds" => [
        ["world_id"=>"1","player_level"=>["min"=>1,"max"=>50]],
        ["world_id"=>"2","player_level"=>["min"=>5,"max"=>50]],
        ["world_id"=>"3","player_level"=>["min"=>15,"max"=>50]],
        ["world_id"=>"4","player_level"=>["min"=>30,"max"=>50]],
        ["world_id"=>"5","player_level"=>["min"=>5,"max"=>50]],
        ["world_id"=>"6","player_level"=>["min"=>10,"max"=>50]],
        ["world_id"=>"7","player_level"=>["min"=>15,"max"=>50]],
    ],
    "owned_morty_limit" => 750
];
sse_send("session:start", json_encode($session, JSON_UNESCAPED_SLASHES));

// wait for room
$room_id = null;
$last_keepalive = time();

while (!connection_aborted()) {
    $stmt = $pdo->prepare("SELECT room_id FROM room_presence WHERE player_id = ? LIMIT 1");
    $stmt->execute([$player_id]);
    $room_id = $stmt->fetchColumn();
    if ($room_id) break;

    $now = time();
    if (($now - $last_keepalive) >= 25) {
        sse_send("session:keep-alive", "0");
        $last_keepalive = $now;
    }
    usleep(250000);
}
if (!$room_id) exit;

// initial snapshot: other users (no self)
$u = $pdo->prepare("SELECT player_id, username, avatar_id, level, state FROM room_presence WHERE room_id = ?");
$u->execute([$room_id]);
foreach ($u->fetchAll(PDO::FETCH_ASSOC) as $row) {
    if ((string)$row["player_id"] === $player_id) continue;
    sse_send("room:user-added", json_encode([
        "player_id" => (string)$row["player_id"],
        "username" => (string)$row["username"],
        "player_avatar_id" => (string)$row["avatar_id"],
        "level" => (int)$row["level"],
        "state" => (string)$row["state"],
    ], JSON_UNESCAPED_SLASHES));
}

// choose last_id
$last_id = 0;

if (!empty($_SERVER['HTTP_LAST_EVENT_ID']) && ctype_digit($_SERVER['HTTP_LAST_EVENT_ID'])) {
    $last_id = (int)$_SERVER['HTTP_LAST_EVENT_ID'];
} else {
    // ✅ must use cursor written by join-room (baseline)
    $cur = cursor_get($pdo, $player_id, $room_id);
    if ($cur !== null) {
        $last_id = $cur;
    } else {
        // emergency fallback only
        $max = $pdo->prepare("SELECT COALESCE(MAX(id), 0) FROM event_queue WHERE room_id = ?");
        $max->execute([$room_id]);
        $last_id = (int)$max->fetchColumn();
    }
}

$keepalive_interval_sec = 30;
$last_keepalive = time();

while (!connection_aborted()) {

    $pdo->prepare("UPDATE room_presence SET last_seen = NOW() WHERE player_id = ?")
        ->execute([$player_id]);

    $stmt = $pdo->prepare("
      SELECT id, event_name, payload_json
      FROM event_queue
      WHERE room_id = ?
        AND id > ?
      ORDER BY id ASC
      LIMIT 200
    ");
    $stmt->execute([$room_id, $last_id]);

    $sent = false;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $eventName = (string)$row["event_name"];
        $payload   = (string)$row["payload_json"];
        $eid       = (int)$row["id"];

        // filter self events
        if (
            in_array($eventName, [
                "room:user-added",
                "room:user-modified",
                "room:user-state-changed",
                "room:user-moved"
            ], true)
            && payload_player_id($payload) === $player_id
        ) {
            $last_id = $eid;
            continue;
        }

        sse_send($eventName, $payload, $eid);
        $last_id = $eid;
        $sent = true;
    }

    cursor_set($pdo, $player_id, $room_id, $last_id);

    $now = time();
    if (!$sent && ($now - $last_keepalive) >= $keepalive_interval_sec) {
        sse_send("session:keep-alive", "0");
        $last_keepalive = $now;
    }

    usleep(300000);
}
