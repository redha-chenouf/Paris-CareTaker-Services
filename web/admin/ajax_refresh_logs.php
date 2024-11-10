<?php
// Inclure les utilitaires et vérifier la session
include("include/utils.php");
checkSessionElseLogin("");

// Vérifier les paramètres reçus
$nfc_id = htmlspecialchars($_GET["id"]);
$id_bien = isset($_GET['id_bien']) ? htmlspecialchars($_GET['id_bien']) : '';
$log_date_time = isset($_GET['log_date_time']) ? htmlspecialchars($_GET['log_date_time']) : '';

// Connexion à la base de données
$db = getDatabase();

try {
    // Construire la requête SQL pour les logs avec filtres
    $log_query = "SELECT * FROM nfc_log WHERE nfc_id = :nfc_id";
    $params = [':nfc_id' => $nfc_id];
    if (!empty($id_bien)) {
        $log_query .= " AND id_bien = :id_bien";
        $params[':id_bien'] = $id_bien;
    }
    if (!empty($log_date_time)) {
        $log_query .= " AND log_date_time LIKE :log_date_time";
        $log_date_time .= '%'; // Pour permettre la recherche par date ou par heure partielle
        $params[':log_date_time'] = $log_date_time;
    }
    $log_query .= " ORDER BY log_date_time DESC";

    // Préparer la requête SQL pour récupérer les logs
    $log_stmt = $db->prepare($log_query);
    $log_stmt->execute($params);
    $logs = $log_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher le tableau des logs mis à jour
    if ($logs) {
        echo '<table class="table table-striped">';
        echo '<thead><tr><th>ID Log</th><th>Date et Heure</th><th>ID Bien</th></tr></thead>';
        echo '<tbody>';
        foreach ($logs as $log) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($log['id_log']) . '</td>';
            echo '<td>' . htmlspecialchars($log['log_date_time']) . '</td>';
            echo '<td><a href="bien.php?id=' . htmlspecialchars($log['id_bien']) . '">' . htmlspecialchars($log['id_bien']) . '</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>Aucun log trouvé pour cet ID NFC.</p>';
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
