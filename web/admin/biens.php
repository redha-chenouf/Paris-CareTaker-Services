<?php
// Inclusion des fichiers nécessaires
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");

// Connexion à la base de données
$db = getDatabase();

try {
    // Récupérer tout les biens
    $stmtAll = $db->prepare("SELECT * FROM bien");
    $stmtAll->execute();
    $biensAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les biens acceptés
    $stmtAcceptes = $db->prepare("SELECT * FROM bien WHERE refus_bot = 0 AND id_administrateur IS NOT NULL");
    $stmtAcceptes->execute();
    $biensAcceptes = $stmtAcceptes->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les biens en attente
    $stmtEnAttente = $db->prepare("SELECT * FROM bien WHERE refus_bot = 0 AND id_administrateur IS NULL");
    $stmtEnAttente->execute();
    $biensEnAttente = $stmtEnAttente->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les biens refusés par le bot
    $stmtRefusBot = $db->prepare("SELECT * FROM bien WHERE refus_bot = 1");
    $stmtRefusBot->execute();
    $biensRefusesBot = $stmtRefusBot->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les biens refusés par l'administrateur
    $stmtRefusAdmin = $db->prepare("SELECT * FROM bien WHERE refus_bot = 0 AND id_administrateur IS NOT NULL AND raison_refus IS NOT NULL");
    $stmtRefusAdmin->execute();
    $biensRefusesAdmin = $stmtRefusAdmin->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des biens</title>
    <!-- Intégration de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Liste des biens</h1>

        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Tous les biens</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="acceptes-tab" data-bs-toggle="tab" data-bs-target="#acceptes" type="button" role="tab" aria-controls="acceptes" aria-selected="false">Acceptés</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attente-tab" data-bs-toggle="tab" data-bs-target="#attente" type="button" role="tab" aria-controls="attente" aria-selected="false">En attente</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refuses-bot-tab" data-bs-toggle="tab" data-bs-target="#refuses-bot" type="button" role="tab" aria-controls="refuses-bot" aria-selected="false">Refusés par le bot</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refuses-admin-tab" data-bs-toggle="tab" data-bs-target="#refuses-admin" type="button" role="tab" aria-controls="refuses-admin" aria-selected="false">Refusés par l'administrateur</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Onglet Tous les Biens -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <input type="text" id="searchBar" class="form-control mb-3" placeholder="Rechercher des biens...">
                <div class="table-responsive">
                    <table class="table table-striped" id="allTable">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($biensAll as $bien): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bien['title']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($bien['description'])); ?></td>
                                    <td>
                                        <a href="bien.php?id=<?php echo $bien['id_bien']; ?>" class="btn btn-primary">Voir les détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Onglet Biens Acceptés -->
            <div class="tab-pane fade" id="acceptes" role="tabpanel" aria-labelledby="acceptes-tab">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($biensAcceptes as $bien): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bien['title']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($bien['description'])); ?></td>
                                    <td>
                                        <a href="bien.php?id=<?php echo $bien['id_bien']; ?>" class="btn btn-primary">Voir les détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Onglet Biens en Attente -->
            <div class="tab-pane fade" id="attente" role="tabpanel" aria-labelledby="attente-tab">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($biensEnAttente as $bien): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bien['title']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($bien['description'])); ?></td>
                                    <td>
                                        <a href="bien.php?id=<?php echo $bien['id_bien']; ?>" class="btn btn-primary">Voir les détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Onglet Biens Refusés par le Bot -->
            <div class="tab-pane fade" id="refuses-bot" role="tabpanel" aria-labelledby="refuses-bot-tab">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($biensRefusesBot as $bien): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bien['title']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($bien['description'])); ?></td>
                                    <td>
                                        <a href="bien.php?id=<?php echo $bien['id_bien']; ?>" class="btn btn-primary">Voir les détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Onglet Biens Refusés par l'Administrateur -->
            <div class="tab-pane fade" id="refuses-admin" role="tabpanel" aria-labelledby="refuses-admin-tab">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($biensRefusesAdmin as $bien): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bien['title']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($bien['description'])); ?></td>
                                    <td>
                                        <a href="bien.php?id=<?php echo $bien['id_bien']; ?>" class="btn btn-primary">Voir les détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- Fin de div.tab-content -->

        <!-- Intégration des scripts JavaScript Bootstrap -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <!-- Script pour la recherche dans l'onglet "Tous les Biens" -->
        <script>
            document.getElementById('searchBar').addEventListener('input', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#allTable tbody tr');
                rows.forEach(row => {
                    let title = row.cells[0].innerText.toLowerCase();
                    let description = row.cells[1].innerText.toLowerCase();
                    if (title.includes(filter) || description.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    </div>
</body>
</html>
