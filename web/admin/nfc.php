<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

// Connexion à la base de données
$db = getDatabase();

$nfc_id = htmlspecialchars($_GET["id"]);
$id_bien = isset($_GET['id_bien']) ? htmlspecialchars($_GET['id_bien']) : '';
$log_date_time = isset($_GET['log_date_time']) ? htmlspecialchars($_GET['log_date_time']) : '';

try {
    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nfc_id = :nfc_id");
    $stmt->bindParam(':nfc_id', $nfc_id, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Construire la requête SQL pour les logs avec filtres
    $log_query = "SELECT * FROM nfc_log WHERE nfc_id = :nfc_id";
    if (!empty($id_bien)) {
        $log_query .= " AND id_bien = :id_bien";
    }
    if (!empty($log_date_time)) {
        $log_query .= " AND log_date_time LIKE :log_date_time";
        $log_date_time .= '%'; // Pour permettre la recherche par date ou par heure partielle
    }
    $log_query .= " ORDER BY log_date_time DESC";

    // Préparer la requête SQL pour récupérer les logs
    $log_stmt = $db->prepare($log_query);
    $log_stmt->bindParam(':nfc_id', $nfc_id, PDO::PARAM_STR);
    if (!empty($id_bien)) {
        $log_stmt->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    }
    if (!empty($log_date_time)) {
        $log_stmt->bindParam(':log_date_time', $log_date_time, PDO::PARAM_STR);
    }
    $log_stmt->execute();
    $logs = $log_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du tag NFC</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <!-- Bootstrap 5 CSS (peut être supprimé si non utilisé) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Informations du tag NFC</h1>
        <p>Voici l'ID du tag NFC reçu : <strong><?php echo htmlspecialchars($nfc_id); ?></strong></p>
        
        <?php
        if ($user) {
            echo "<p>Appartient à : <a href='bdetails.php?id=". htmlspecialchars($user["id_utilisateur"]) ."'><strong>" . htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']) . "</strong></a></p>";
        } else {
            echo "<p>Aucun utilisateur trouvé pour cet ID NFC.</p>";
        }
        ?>

        <h2>Logs associés</h2>
        
        <form id="filterForm" method="GET" class="mb-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($nfc_id); ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_bien">ID Bien</label>
                    <input type="text" class="form-control" id="id_bien" name="id_bien" value="<?php echo htmlspecialchars($id_bien); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="log_date_time">Date/Heure</label>
                    <input type="text" class="form-control datepicker" id="log_date_time" name="log_date_time" value="<?php echo htmlspecialchars($log_date_time); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <div id="logsTable">
            <?php if ($logs): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Log</th>
                            <th>Date et Heure</th>
                            <th>ID Bien</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($log['id_log']); ?></td>
                                <td><?php echo htmlspecialchars($log['log_date_time']); ?></td>
                                <td><a href="bien.php?id=<?= $log['id_bien'] ?>"><?php echo htmlspecialchars($log['id_bien']); ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun log trouvé pour cet ID NFC.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Chargement des scripts JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap 5 JS (peut être supprimé si non utilisé) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Script pour rafraîchir les logs avec AJAX -->
    <script>
        $(document).ready(function(){
            // Initialisation du datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // Fonction pour rafraîchir les logs toutes les 5 secondes
            function refreshLogs() {
                var formData = $('#filterForm').serialize(); // Sérialiser les données du formulaire

                // Effectuer la requête AJAX
                $.ajax({
                    type: 'GET',
                    url: 'ajax_refresh_logs.php', // URL pour la requête AJAX
                    data: formData, // Données à envoyer, sérialisées
                    success: function(response) {
                        $('#logsTable').html(response); // Mettre à jour le contenu des logs avec la réponse
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la requête AJAX : ' + status + ', ' + error);
                    },
                    complete: function() {
                        // Lancer la prochaine requête après 5 secondes
                        setTimeout(refreshLogs, 1000); // 5000 millisecondes = 5 secondes
                    }
                });
            }

            // Démarrer la première mise à jour des logs
            refreshLogs();
        });
    </script>
</body>
</html>
