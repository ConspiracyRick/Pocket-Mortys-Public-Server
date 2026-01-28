<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

set_time_limit(0);
ignore_user_abort(true);

// SSE headers
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");
header("X-Accel-Buffering: no");

// Kill buffering
while (ob_get_level() > 0) ob_end_flush();
flush();

// ---------------- JWT decode ----------------
function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function decode_jwt_payload($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) < 2) return null;
    return json_decode(base64url_decode($parts[1]), true);
}

// ---------------- Token ----------------
$token = $_GET['token'] ?? null;
$profile = $token ? decode_jwt_payload($token) : [];

$player_id = $profile['player_id'];
$username = $profile['username'];
$level = $profile['level'];
$tags = $profile['tags'];
$session_id = $profile['session_id'];
$ping_url = $profile['ping_url'];
$exp = $profile['exp'];

$now = time();
if ($exp < $now) {
    die("Token expired");
}

// Verify extracted info from token against the database.


// ---------------- Player ----------------
$player = [
    "player_id" => $profile["player_id"] ?? "guest-" . uniqid(),
    "username" => $profile["username"] ?? "ConspiracyRick",
    "level" => (int)($profile["level"] ?? 8),
    "tags" => $profile["tags"] ?? [],
    "owned_morty_limit" => (int)($profile["owned_morty_limit"] ?? 750)
];

// ---------------- Session ----------------
$session = [
    "player_id" => $player_id,
    "session_id" => $session_id,
    "username" => $username,
    "level" => $level,
    "tags" => $tags,
    "ping_interval" => 30,
    "ping_url" => $ping_url,
    "keep_alive" => 30,
    "server_instance" => "/emulated-server/0/9999",
    "worlds" => [
        ["world_id"=>"1","player_level"=>["min"=>1,"max"=>50]],
        ["world_id"=>"2","player_level"=>["min"=>5,"max"=>50]],
        ["world_id"=>"3","player_level"=>["min"=>15,"max"=>50]],
        ["world_id"=>"4","player_level"=>["min"=>30,"max"=>50]],
        ["world_id"=>"5","player_level"=>["min"=>5,"max"=>50]],
        ["world_id"=>"6","player_level"=>["min"=>10,"max"=>50]],
        ["world_id"=>"7","player_level"=>["min"=>15,"max"=>50]],
    ],
    "owned_morty_limit" => $player["owned_morty_limit"]
];

// ---------------- SSE send ----------------
function send_event($event, $data) {
    echo "event: $event\n";
    echo "retry: 1000\n";
    echo "data: $data\n\n";
    flush();
}

// ---------------- Initial events ----------------
send_event("session:start", json_encode($session, JSON_UNESCAPED_SLASHES));
usleep(200000); // important pacing

send_event("room:user-state-changed", json_encode([
    "player_id" => $player["player_id"],
    "state" => "WORLD"
], JSON_UNESCAPED_SLASHES));

// ---------------- Keep alive loop ----------------
while (!connection_aborted()) {
    sleep(25);
    send_event("session:keep-alive", "0");
}