<?php
require '../database/config.php';

function generateToken($userId, $pdo) {
    $token = bin2hex(random_bytes(16));
    $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO tokens (user_id, token, expires_at) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $token, $expiresAt]);

    return $token;
}
?>
