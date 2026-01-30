<?php
// lib/events.php

function publish_event(PDO $pdo, string $room_id, string $event, array $payload, ?string $target_player_id = null): void {
    // If you later add per-player targeting, you can add a column.
    $stmt = $pdo->prepare("
        INSERT INTO event_queue (room_id, event_name, payload_json)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $room_id,
        $event,
        json_encode($payload, JSON_UNESCAPED_SLASHES)
    ]);
}

function sse_send(string $event, string $dataJson): void {
    echo "event: {$event}\n";
    echo "data: {$dataJson}\n\n";
    @ob_flush();
    @flush();
}