<?php
require_once __DIR__ . "/events.php";

function uuidv4(): string {
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function now_iso_z(): string {
    return gmdate("Y-m-d\TH:i:s.v\Z"); // milli-ish formatting is fine for clients
}

function room_is_initialized(PDO $pdo, string $room_id): bool {
    $stmt = $pdo->prepare("
      SELECT 1
      FROM event_queue
      WHERE room_id = ?
        AND event_name = 'room:initialized'
      LIMIT 1
    ");
    $stmt->execute([$room_id]);
    return (bool)$stmt->fetchColumn();
}

function seed_room_entities(PDO $pdo, string $room_id, string $world_id, string $zone_id): void {
    // deterministic-ish per room so it’s stable across restarts
    mt_srand((int) sprintf("%u", crc32($room_id)));

    publish_event($pdo, $room_id, "room:initialized", [
        "world_id" => $world_id,
        "zone_id" => $zone_id,
        "_created" => now_iso_z()
    ]);

    // --- pickups ---
    $items = ["ItemCable","ItemPlutonicRock","ItemSerum","ItemBacteriaCell","ItemCircuitBoard","ItemTinCan"];
    for ($i=0; $i<6; $i++) {
        $pickup_id = uuidv4();
        $x = mt_rand(0, 70);
        $y = mt_rand(0, 90);

        $contents = [];
        $contents[] = [
            "type" => "ITEM",
            "amount" => 1,
            "item_id" => $items[array_rand($items)],
            "rarity" => 100
        ];
        if (mt_rand(0, 100) < 35) {
            $contents[] = ["type" => "COIN", "amount" => mt_rand(50, 250)];
        }

        publish_event($pdo, $room_id, "room:pickup-added", [
            "contents" => $contents,
            "placement" => [$x, $y],
            "pickup_id" => $pickup_id
        ]);
    }

    // --- wild morties ---
    $wild_pool = ["MortyDefault","MortyPrisoner","MortySurvivor","MortyCowboy","MortyBlueShirt","MortyNoEye"];
    for ($i=0; $i<5; $i++) {
        $wid = uuidv4();
        $x = mt_rand(0, 70);
        $y = mt_rand(0, 90);

        $created = now_iso_z();
        publish_event($pdo, $room_id, "room:wild-morty-added", [
            "morty_id" => $wild_pool[array_rand($wild_pool)],
            "placement" => [$x, $y],
            "state" => "WORLD",
            "division" => mt_rand(1, 4),
            "variant" => (mt_rand(0,100) < 10 ? "Shiny" : "Normal"),
            "shiny_if_potion" => (mt_rand(0,100) < 25),
            "_created" => $created,
            "_updated" => $created,
            "wild_morty_id" => $wid
        ]);
    }

    // --- bots ---
    $bot_names = ["Ataraxy","Carpedge","ChloeTombola","Loxodromy","Barbirdation","EasementJustice"];
    $bot_avatars = ["AvatarTeacherRick","AvatarMoochJerry","AvatarBeth","AvatarRickSuperFan","AvatarRickDefault"];
    $bot_morties = ["MortyPoorHouse","MortyGunk","MortySoldier","MortyTyrantLizard","MortyAndroid"];

    for ($i=0; $i<4; $i++) {
        $bot_id = uuidv4();
        $zx = mt_rand(1, 5);
        $zy = mt_rand(1, 5);

        $created = now_iso_z();
        publish_event($pdo, $room_id, "room:bot-added", [
            "username" => $bot_names[array_rand($bot_names)],
            "player_avatar_id" => $bot_avatars[array_rand($bot_avatars)],
            "state" => "WORLD",
            "level" => 5,
            "owned_morties" => [[
                "morty_id" => $bot_morties[array_rand($bot_morties)],
                "variant" => "Normal",
                "hp" => 1,
                "owned_morty_id" => "80700000-0000-0000-0000-000000000000"
            ]],
            "zone" => [
                "player" => [$zx, $zy],
                "bots" => [
                    "count" => mt_rand(6, 12),
                    "morty_count" => ["min" => 1, "max" => 1],
                    "morty_hp_handicap" => ["min" => 0.4, "max" => 0.6]
                ],
                "zone_id" => "[{$zx}-{$zy}]"
            ],
            "streak" => 0,
            "_created" => $created,
            "_updated" => $created,
            "bot_id" => $bot_id
        ]);
    }
}

function build_room_snapshot_from_events(PDO $pdo, string $room_id): array {
    // Apply events in order to rebuild current state
    $stmt = $pdo->prepare("
      SELECT event_name, payload_json
      FROM event_queue
      WHERE room_id = ?
        AND event_name IN (
          'room:pickup-added','room:pickup-removed',
          'room:wild-morty-added','room:wild-morty-removed','room:wild-morty-state-changed',
          'room:bot-added','room:bot-removed','room:bot-state-changed'
        )
      ORDER BY id ASC
    ");
    $stmt->execute([$room_id]);

    $pickups = [];      // pickup_id => pickup
    $wilds = [];        // wild_morty_id => wild
    $bots = [];         // bot_id => bot

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $event = $row["event_name"];
        $payload = json_decode($row["payload_json"], true);
        if (!is_array($payload)) continue;

        if ($event === "room:pickup-added" && !empty($payload["pickup_id"])) {
            $pickups[$payload["pickup_id"]] = $payload;
        }
        if ($event === "room:pickup-removed" && !empty($payload["pickup_id"])) {
            unset($pickups[$payload["pickup_id"]]);
        }

        if ($event === "room:wild-morty-added" && !empty($payload["wild_morty_id"])) {
            $wilds[$payload["wild_morty_id"]] = $payload;
        }
        if ($event === "room:wild-morty-removed" && !empty($payload["wild_morty_id"])) {
            unset($wilds[$payload["wild_morty_id"]]);
        }
        if ($event === "room:wild-morty-state-changed" && !empty($payload["wild_morty_id"])) {
            $id = $payload["wild_morty_id"];
            if (isset($wilds[$id]) && isset($payload["state"])) {
                $wilds[$id]["state"] = $payload["state"];
                $wilds[$id]["_updated"] = now_iso_z();
            }
        }

        if ($event === "room:bot-added" && !empty($payload["bot_id"])) {
            $bots[$payload["bot_id"]] = $payload;
        }
        if ($event === "room:bot-removed" && !empty($payload["bot_id"])) {
            unset($bots[$payload["bot_id"]]);
        }
        if ($event === "room:bot-state-changed" && !empty($payload["bot_id"])) {
            $id = $payload["bot_id"];
            if (isset($bots[$id]) && isset($payload["state"])) {
                $bots[$id]["state"] = $payload["state"];
                $bots[$id]["_updated"] = now_iso_z();
            }
        }
    }

    return [
        "pickups" => array_values($pickups),
        "wild_morties" => array_values($wilds),
        "bots" => array_values($bots),
    ];
}
