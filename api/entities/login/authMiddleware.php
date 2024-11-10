<?php
require '../database/config.php';

function authenticate($pdo) {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header not found']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $stmt = $pdo->prepare('SELECT user_id FROM tokens WHERE token = ? AND expires_at > NOW()');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid or expired token']);
        exit;
    }

    return $user['user_id'];
}
?>
