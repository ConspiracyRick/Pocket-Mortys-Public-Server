<?php
// lib/auth.php
function require_user_by_session(PDO $pdo, string $session_id): array {
    $stmt = $pdo->prepare("
        SELECT player_id, username, player_avatar_id, level
        FROM users
        WHERE session_id = ?
        LIMIT 1
    ");
    $stmt->execute([$session_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode(["success" => false, "error" => "Not authenticated"]);
        exit;
    }
    return $user;
}