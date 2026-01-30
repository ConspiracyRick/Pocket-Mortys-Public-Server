<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=utf-8");

require __DIR__ . "/../../pocket_f4894h398r8h9w9er8he98he.php";
require_once __DIR__ . "/../../lib/events.php";
require_once __DIR__ . "/../../lib/room_entities.php";
require_once __DIR__ . "/../../lib/auth.php";

$body = json_decode(file_get_contents("php://input"), true) ?: [];
$session_id = $body["session_id"] ?? "";
$world_id   = (string)($body["world_id"] ?? "");

if ($session_id === "" || $world_id === "") {
  http_response_code(400);
  echo json_encode(["error" => "Missing session_id or world_id"], JSON_UNESCAPED_SLASHES);
  exit;
}

// --- Auth: session_id -> user ---
$stmt = $pdo->prepare("
  SELECT player_id, username, player_avatar_id, level
  FROM users
  WHERE session_id = ?
  LIMIT 1
");
$stmt->execute([$session_id]);
$me = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$me) {
  http_response_code(401);
  echo json_encode(["error" => "Not authenticated"], JSON_UNESCAPED_SLASHES);
  exit;
}

$my_player_id = (string)$me["player_id"];

// --- Choose room/zone (your logic here later) ---
$room_id = "76092cc3-d968-4d2d-8c54-98ed0817bc5a";
$zone_id = "[13-15]";

// ✅ Cursor baseline FIRST (so SSE will stream everything that happens after join-room is called)
$maxBefore = $pdo->prepare("SELECT COALESCE(MAX(id), 0) FROM event_queue WHERE room_id = ?");
$maxBefore->execute([$room_id]);
$baseline_event_id = (int)$maxBefore->fetchColumn();

$cur = $pdo->prepare("
  INSERT INTO room_stream_cursor (player_id, room_id, last_event_id)
  VALUES (?, ?, ?)
  ON DUPLICATE KEY UPDATE last_event_id = VALUES(last_event_id), updated_at = NOW()
");
$cur->execute([$my_player_id, $room_id, $baseline_event_id]);

// --- Upsert presence ---
$up = $pdo->prepare("
  INSERT INTO room_presence (player_id, room_id, username, avatar_id, level, state)
  VALUES (?, ?, ?, ?, ?, 'WORLD')
  ON DUPLICATE KEY UPDATE
    room_id = VALUES(room_id),
    username = VALUES(username),
    avatar_id = VALUES(avatar_id),
    level = VALUES(level),
    state = 'WORLD',
    last_seen = NOW()
");
$up->execute([
  $my_player_id,
  $room_id,
  $me['username'],
  $me['player_avatar_id'],
  (int)$me['level'],
]);

// --- Snapshot: get all users currently in this room ---
$pres = $pdo->prepare("
  SELECT player_id, username, avatar_id, level, state
  FROM room_presence
  WHERE room_id = ?
  ORDER BY last_seen DESC
");
$pres->execute([$room_id]);
$present_users = $pres->fetchAll(PDO::FETCH_ASSOC);

// --- Incentive (safe default) ---
$incentive = [
  "incentive_id" => "NPCAd",
  "rewards" => [
    ["type" => "ITEM", "amount" => 1, "item_id" => "ItemSerum", "rarity" => 100],
    ["type" => "ITEM", "amount" => 1, "item_id" => "ItemParalysisCure", "rarity" => 75],
    ["type" => "COIN", "amount" => 200],
  ],
  "token" => ""
];

// --- Build morties map for everyone in room ---
$player_ids = array_values(array_unique(array_map(fn($r) => (string)$r["player_id"], $present_users)));
$morties_by_player = [];

if (count($player_ids) > 0) {
  $placeholders = implode(",", array_fill(0, count($player_ids), "?"));
  $mstmt = $pdo->prepare("
    SELECT
      player_id,
      owned_morty_id,
      morty_id,
      hp,
      variant,
      is_locked,
      is_trading_locked,
      fight_pit_id
    FROM owned_morties
    WHERE player_id IN ($placeholders)
    ORDER BY id ASC
  ");
  $mstmt->execute($player_ids);

  while ($m = $mstmt->fetch(PDO::FETCH_ASSOC)) {
    $pid = (string)$m["player_id"];
    if (!isset($morties_by_player[$pid])) $morties_by_player[$pid] = [];

    $is_locked = ($m["is_locked"] === "true" || $m["is_locked"] === "1" || $m["is_locked"] === 1);
    $is_trading_locked = ($m["is_trading_locked"] === "true" || $m["is_trading_locked"] === "1" || $m["is_trading_locked"] === 1);

    $morties_by_player[$pid][] = [
      "owned_morty_id" => (string)$m["owned_morty_id"],
      "morty_id" => (string)$m["morty_id"],
      "hp" => (int)$m["hp"],
      "variant" => $m["variant"] ?: "Normal",
      "is_locked" => (bool)$is_locked,
      "is_trading_locked" => (bool)$is_trading_locked,
      "fight_pit_id" => ($m["fight_pit_id"] === null || $m["fight_pit_id"] === "null") ? null : (string)$m["fight_pit_id"]
    ];
  }
}

// --- Assemble users array ---
$users = [];
foreach ($present_users as $u) {
  $pid = (string)$u["player_id"];
  $users[] = [
    "player_id" => $pid,
    "username" => (string)$u["username"],
    "player_avatar_id" => (string)$u["avatar_id"],
    "level" => (int)$u["level"],
    "owned_morties" => $morties_by_player[$pid] ?? [],
    "state" => ($u["state"] ?: "WORLD")
  ];
}

// --- Ensure room has initial entities (this may publish events) ---
if (!room_is_initialized($pdo, $room_id)) {
  seed_room_entities($pdo, $room_id, $world_id, $zone_id);
}

// Build snapshot arrays from event history (for join-room response)
$entities = build_room_snapshot_from_events($pdo, $room_id);

// ✅ NOW announce join to everyone else (SSE filters self on their own connection)
publish_event($pdo, $room_id, "room:user-added", [
  "player_id" => $my_player_id,
  "username" => (string)$me["username"],
  "player_avatar_id" => (string)$me["player_avatar_id"],
  "level" => (int)$me["level"],
  "owned_morties" => $morties_by_player[$my_player_id] ?? [],
  "state" => "WORLD"
]);

$response = [
  "room_id" => $room_id,
  "room_udp_host" => "18.117.91.104",
  "room_udp_port" => "13001",
  "world_id" => $world_id,
  "zone_id" => $zone_id,
  "incentive" => $incentive,
  "users" => $users,
  "pickups" => $entities["pickups"] ?? [],
  "wild_morties" => $entities["wild_morties"] ?? [],
  "bots" => $entities["bots"] ?? [],

  // debug
  "baseline_event_id" => $baseline_event_id
];

echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
