<?php
$host = "localhost";
$dbname = "private_server_pocket_mortys";
$user = "pocketmortys";
$pass = "HaRS83Zn3ye8760r";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Nice array format
            PDO::ATTR_EMULATE_PREPARES => false, // Real prepared statements
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}