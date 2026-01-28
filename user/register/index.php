<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

require '../../pocket_f4894h398r8h9w9er8he98he.php';

$input = file_get_contents('php://input');

if ($input === false || $input === '') {
    http_response_code(400);
    echo json_encode(['error' => 'No input received']);
    exit;
}

$data = json_decode($input, true);

function uuidv4() {
    $data = random_bytes(16);

    // Set version to 0100 (UUID v4)
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);

    // Set variant to 10xx
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$username = $data['username'];
$player_avatar_ids = $data['player_avatar_ids'];

$avatarJson = json_encode($player_avatar_ids);
$secret = uuidv4();
$player_id = uuidv4();
$owned_morty_id = uuidv4();
$owned_morty_idJson = json_encode([$owned_morty_id]);

do {
    try {
        $secret = uuidv4();
		
        $stmt_1 = $pdo->prepare("
            INSERT INTO users (secret, player_id, username, player_avatar_id, level, xp, streak, active_deck_id, decks_owned, tags, xp_lower, xp_upper)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
		$stmt_1->execute([$secret, $player_id, $username, $avatarJson, '1', '27', '0', '0', '3', '[]', '27', '64']);
		
		
		$stmt_2 = $pdo->prepare("
            INSERT INTO decks (player_id, deck_id, owned_morty_ids)
            VALUES (?, ?, ?)
        ");
		$stmt_2->execute([$player_id, '0', $owned_morty_idJson]);
		
		
		$stmt_3 = $pdo->prepare("
            INSERT INTO owned_items (player_id, item_id, quantity)
            VALUES (?, ?, ?)
        ");
		$stmt_3->execute([$player_id, 'ItemMortyChip', '1']);
		$stmt_3->execute([$player_id, 'ItemSerum', '1']);
		
		
		$stmt_4 = $pdo->prepare("
            INSERT INTO owned_avatars (player_id, player_avatar_id)
            VALUES (?, ?)
        ");
		$stmt_4->execute([$player_id, $avatarJson]);
		
		
		$stmt_5 = $pdo->prepare("
            INSERT INTO mortydex (player_id, morty_id, caught)
            VALUES (?, ?, ?)
        ");
		$stmt_5->execute([$player_id, 'MortyDefault', 'true']);
		
		
		$stmt_6 = $pdo->prepare("
            INSERT INTO owned_morties (player_id, owned_morty_id, morty_id, level, xp, hp, hp_stat, attack_stat, defence_stat, variant, speed_stat, is_locked, is_trading_locked, fight_pit_id, evolution_points, xp_lower, xp_upper)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
		$stmt_6->execute([$player_id, $owned_morty_id, 'MortyDefault', '5', '125', '20', '20', '11', '10', 'Normal', '10', 'false', 'false', 'null', '0', '125', '216']);
		
		
		$stmt_7 = $pdo->prepare("
            INSERT INTO owned_attacks (owned_morty_id, attack_id, position, pp, pp_stat)
            VALUES (?, ?, ?, ?, ?)
        ");
		$stmt_7->execute([$owned_morty_id, 'AttackOutburst', '0', '12', '12']);
		
        $success = true;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            // Duplicate key → regenerate
            $success = false;
        } else {
            throw $e;
        }
    }
} while (!$success);

// Grab data right after register
$stmt = $pdo->prepare("SELECT * FROM users WHERE player_id = ?");
$stmt->execute([$player_id]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM owned_morties WHERE player_id = ?");
$stmt->execute([$player_id]);
$morties = $stmt->fetchAll();

foreach ($morties as &$morty) {
    $stmt = $pdo->prepare("SELECT attack_id, position, pp, pp_stat FROM owned_attacks WHERE owned_morty_id = ?");
    $stmt->execute([$morty['owned_morty_id']]);
    $morty['owned_attacks'] = $stmt->fetchAll();
}

$stmt = $pdo->prepare("SELECT deck_id, owned_morty_ids FROM decks WHERE player_id = ?");
$stmt->execute([$player_id]);
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($decks as &$deck) {

    // If in future you store multiple IDs as JSON, auto-handle it:
    if (strpos($deck['owned_morty_ids'], '[') === 0) {
        $deck['owned_morty_ids'] = json_decode($deck['owned_morty_ids'], true);
    } else {
        // Current format: single ID string
        $deck['owned_morty_ids'] = [$deck['owned_morty_ids']];
    }
}

$stmt = $pdo->prepare("SELECT item_id, quantity FROM owned_items WHERE player_id = ?");
$stmt->execute([$player_id]);
$items = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT morty_id, caught FROM mortydex WHERE player_id = ?");
$stmt->execute([$player_id]);
$mortydex = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT player_avatar_id FROM owned_avatars WHERE player_id = ?");
$stmt->execute([$player_id]);
$row = $stmt->fetch();
$avatars = json_decode($row['player_avatar_id'], true);

// output the response
$response = json_encode([
    "player_id" => $user['player_id'],
    "username" => $user['username'],
    "player_avatar_ids" => $avatars,
    "level" => (int)$user['level'],
    "xp" => (int)$user['xp'],
    "streak" => (int)$user['streak'],

    "owned_morties" => $morties,
    "active_deck_id" => (int)$user['active_deck_id'],
    "decks_owned" => (int)$user['decks_owned'],
    "decks" => $decks,
    "owned_items" => $items,
    "mortydex" => $mortydex,
    "tags" => json_decode($user['tags'], true),
    "xp_lower" => (int)$user['xp_lower'],
    "xp_upper" => (int)$user['xp_upper'],
    "secret" => $user['secret']
], JSON_UNESCAPED_SLASHES);

$etag = 'W/"' . md5($response) . '"';

header("ETag: $etag");

// if we ever need it to error out
//echo $username;

// output response
echo $response;