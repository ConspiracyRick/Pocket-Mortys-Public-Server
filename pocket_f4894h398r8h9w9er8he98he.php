<?php
$dsn = "mysql:host=localhost;port=3306;dbname=pocket_mortys;charset=utf8mb4";

$pdo = new PDO($dsn, "pocketmortys", "yourpassword", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_TIMEOUT => 5,
]);