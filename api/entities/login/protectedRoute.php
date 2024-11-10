<?php
require 'authMiddleware.php';

$userId = authenticate($pdo);

// Votre logique pour les utilisateurs authentifiés
echo json_encode(['message' => 'You have access', 'user_id' => $userId]);
?>
