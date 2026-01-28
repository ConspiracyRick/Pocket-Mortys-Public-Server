<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

$response = json_encode([
    "room_id" => "76092cc3-d968-4d2d-8c54-98ed0817bc5a",
    "room_udp_host" => "18.117.91.104",
    "room_udp_port" => "13001",
    "world_id" => "1",
    "zone_id" => "[13-15]",
    "incentive" => [
        "incentive_id" => "NPCAd",
        "rewards" => [
            [
                "type" => "ITEM",
                "amount" => 1,
                "item_id" => "ItemSerum",
                "rarity" => 100
            ],
            [
                "type" => "ITEM",
                "amount" => 1,
                "item_id" => "ItemParalysisCure",
                "rarity" => 75
            ],
            [
                "type" => "COIN",
                "amount" => 200
            ]
        ],
        "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyZXdhcmRzIjpbeyJ0eXBlIjoiSVRFTSIsImFtb3VudCI6MSwiaXRlbV9pZCI6Ikl0ZW1TZXJ1bSIsInJhcml0eSI6MTAwfSx7InR5cGUiOiJJVEVNIiwiYW1vdW50IjoxLCJpdGVtX2lkIjoiSXRlbVBhcmFseXNpc0N1cmUiLCJyYXJpdHkiOjc1fSx7InR5cGUiOiJDT0lOIiwiYW1vdW50IjoyMDB9XSwiaWF0IjoxNzU5ODIzMDA3fQ.kiAPiIbS5UUlaBa1fN-HmaPtIvyiii2_NGKhio223Pw"
    ],
    "users" => [
        [
            "player_id" => "b8e6e279-6deb-4163-9e8d-8b5c523d6056",
            "username" => "Butt_Tickle",
            "player_avatar_id" => "AvatarSleepyGarry",
            "level" => 5,
            "owned_morties" => [
                [
                    "owned_morty_id" => "e1d9f66e-aa9d-11ef-880a-a33f715c2e3c",
                    "morty_id" => "MortyTicketsPlease",
                    "hp" => 78,
                    "variant" => "Normal",
                    "is_locked" => false,
                    "is_trading_locked" => true,
                    "fight_pit_id" => "daadd158-cdca-11ef-aa79-f3d2027803c4"
                ],
                [
                    "owned_morty_id" => "79f21352-4f75-11ef-b552-fff1253e757b",
                    "morty_id" => "MortyGlockenspiel",
                    "hp" => 434,
                    "variant" => "Normal",
                    "is_locked" => false,
                    "is_trading_locked" => true,
                    "fight_pit_id" => "daadd158-cdca-11ef-aa79-f3d2027803c4"
                ],
                // ... other morties for this user ...
            ],
            "state" => "WORLD"
        ],
        [
            "player_id" => "e8ea59de-9c66-40fc-a39e-72bb3f321f63",
            "username" => "dark_bulter",
            "player_avatar_id" => "AvatarRickDefault",
            "level" => 5,
            "owned_morties" => [
                [
                    "owned_morty_id" => "f17576f8-a32f-11f0-90da-1f2d78901606",
                    "morty_id" => "MortyAndroid",
                    "hp" => 38,
                    "variant" => "Normal",
                    "is_locked" => false,
                    "is_trading_locked" => true,
                    "fight_pit_id" => "dabe5afa-cdca-11ef-ba3c-9fb7b3b33be2"
                ],
                // ... other morties ...
            ],
            "state" => "OCCUPIED"
        ],
        [
            "player_id" => "f72a947d-685e-4eab-9fe5-8e07ff55b186",
            "username" => "ibkbjjnkin",
            "player_avatar_id" => "AvatarRickDefault",
            "level" => 5,
            "owned_morties" => [
                [
                    "owned_morty_id" => "9f3852a3-5591-41d8-9e9a-17a3bebcdf09",
                    "morty_id" => "MortyDefault",
                    "hp" => 29,
                    "variant" => "Normal",
                    "is_locked" => false,
                    "is_trading_locked" => false,
                    "fight_pit_id" => null
                ],
                // ... other morties ...
            ],
            "state" => "WORLD"
        ]
    ],
    "pickups" => [
        [
            "contents" => [
                [
                    "type" => "ITEM",
                    "amount" => 1,
                    "item_id" => "ItemCable",
                    "rarity" => 100
                ]
            ],
            "placement" => [42, 64],
            "pickup_id" => "181875a0-a351-11f0-b3db-ed7f54f6c24a"
        ],
        [
            "contents" => [
                [
                    "type" => "ITEM",
                    "amount" => 1,
                    "item_id" => "ItemPlutonicRock",
                    "rarity" => 100
                ],
                [
                    "type" => "ITEM",
                    "amount" => 1,
                    "item_id" => "ItemSerum",
                    "rarity" => 100
                ],
                [
                    "type" => "COIN",
                    "amount" => 196
                ]
            ],
            "placement" => [25, 87],
            "pickup_id" => "1e5cc4c0-a351-11f0-98f6-417ce7b1d5b6"
        ],
        [
            "contents" => [
                [
                    "type" => "ITEM",
                    "amount" => 1,
                    "item_id" => "ItemBacteriaCell",
                    "rarity" => 100
                ]
            ],
            "placement" => [8, 57],
            "pickup_id" => "c79690d0-a350-11f0-bcc4-3f3cb97bfd4b"
        ]
    ],
    "wild_morties" => [
        [
            "morty_id" => "MortyPrisoner",
            "placement" => [32, 72],
            "state" => "WORLD",
            "division" => 1,
            "variant" => "Normal",
            "shiny_if_potion" => false,
            "_created" => "2025-10-07T05:40:35.168Z",
            "_updated" => "2025-10-07T05:40:35.168Z",
            "wild_morty_id" => "258c6e00-a340-11f0-affc-7d02f0f2cb3b"
        ],
        [
            "morty_id" => "MortySurvivor",
            "placement" => [49, 84],
            "state" => "WORLD",
            "division" => 1,
            "variant" => "Shiny",
            "shiny_if_potion" => false,
            "_created" => "2025-10-07T06:34:21.601Z",
            "_updated" => "2025-10-07T06:34:21.601Z",
            "wild_morty_id" => "a8a70910-a347-11f0-845f-679ff830f02d"
        ],
        // ... other wild morties ...
    ],
    "bots" => [
        [
            "username" => "Ataraxy",
            "player_avatar_id" => "AvatarTeacherRick",
            "state" => "WORLD",
            "level" => 5,
            "owned_morties" => [
                [
                    "morty_id" => "MortyPoorHouse",
                    "variant" => "Normal",
                    "hp" => 1,
                    "owned_morty_id" => "80700000-0000-0000-0000-000000000000"
                ],
                // ... other bot morties ...
            ],
            "zone" => [
                "player" => [5, 5],
                "bots" => [
                    "count" => 8,
                    "morty_count" => [
                        "min" => 3,
                        "max" => 4
                    ],
                    "morty_hp_handicap" => [
                        "min" => 0.4,
                        "max" => 0.6
                    ]
                ],
                "zone_id" => "[5-5]"
            ],
            "streak" => 0,
            "_created" => "2025-10-07T07:32:27.557Z",
            "_updated" => "2025-10-07T07:32:27.557Z",
            "bot_id" => "c671b550-a34f-11f0-bcc4-3f3cb97bfd4b"
        ],
        // ... other bots (Ataraxy, Barbirdation, EasementJustice, etc.) ...
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo $response;