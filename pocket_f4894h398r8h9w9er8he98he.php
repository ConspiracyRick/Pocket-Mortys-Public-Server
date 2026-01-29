<?php
$dsn = "mysql:host=74.208.251.41;port=3306;dbname=private_server_pocket_mortys;charset=utf8mb4";

$pdo = new PDO($dsn, "pocketmortys", "HaRS83Zn3ye8760r", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_TIMEOUT => 5,
]);