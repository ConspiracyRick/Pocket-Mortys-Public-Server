<?php
header("Content-Type: application/json; charset=utf-8");
header("X-Powered-By: Express");
header("Access-Control-Allow-Origin: *");
header("Vary: Accept-Encoding");

echo '{
	"config_data": {
		"config_id": "MP",
		"starting_deck_slots": 3,
		"max_deck_slots": 9,
		"cost_additional_slot": 5
	}
}';