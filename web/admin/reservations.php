<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

// Get the database connection
$db = getDatabase();

// Fetch all reservations
try {
    $stmt = $db->prepare("SELECT * FROM occupation");
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

function indispo($reservation){
    if ($reservation['raison_indispo'] != NULL) {
        echo $reservation['raison_indispo'];
    } else {
        echo " ";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Réservations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Occupation</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Raison Indisponibilité</th>
                    <th>Nombre de Personnes</th>
                    <th>Status</th>
                    <th>ID Bien</th>
                    <th>ID Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['id_occupation']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['date_debut']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['date_fin']); ?></td>
                        <td><?php echo htmlspecialchars(indispo($reservation)); ?></td>
                        <td><?php echo htmlspecialchars($reservation['nombre_personne']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['id_bien']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['id_utilisateur']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>