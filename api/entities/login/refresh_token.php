<?php
require_once '../database/config.php';
require_once 'token_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $refreshToken = $data['refresh_token'];

    $sql = "SELECT * FROM refresh_tokens WHERE refresh_token = :refresh_token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['refresh_token' => $refreshToken]);
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tokenData && new DateTime($tokenData['expiry_date']) > new DateTime()) {
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $tokenData['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $token = generateToken($user['id_utilisateur'], $pdo);

        // Generate a new refresh token
        $newRefreshToken = bin2hex(random_bytes(64));
        $newExpiryDate = (new DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
        $sql = "UPDATE refresh_tokens SET refresh_token = :new_refresh_token, expiry_date = :new_expiry_date WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'new_refresh_token' => $newRefreshToken,
            'new_expiry_date' => $newExpiryDate,
            'id' => $tokenData['id']
        ]);

        echo json_encode(['token' => $token, 'refresh_token' => $newRefreshToken]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid or expired refresh token']);
    }
}
?>
