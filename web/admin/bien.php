<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: biens.php?msg=id non reconnu&err=true");
    exit;
}

$db = getDatabase();

$id_bien = htmlspecialchars($_GET['id']);

try {
    $stmt = $db->prepare("SELECT * FROM bien WHERE id_bien = :id_bien");
    $stmt->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmt->execute();
    $bien = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$bien) {
        header("Location: biens.php");
        exit;
    }

    $stmtUtilisateur = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
    $stmtUtilisateur->bindParam(':id_utilisateur', $bien['id_bailleur'], PDO::PARAM_INT);
    $stmtUtilisateur->execute();
    $bailleur = $stmtUtilisateur->fetch(PDO::FETCH_ASSOC);

    $admin = null;
    if (isset($bien['id_administrateur'])) {
        $stmtAdmin = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $stmtAdmin->bindParam(':id_utilisateur', $bien['id_administrateur'], PDO::PARAM_INT);
        $stmtAdmin->execute();
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
    }

    $stmtPhotos = $db->prepare("SELECT * FROM photo WHERE id_bien = :id_bien");
    $stmtPhotos->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmtPhotos->execute();
    $photos = $stmtPhotos->fetchAll(PDO::FETCH_ASSOC);

    // Fetching passages des prestataires, reservations, and interventions data
    $stmtPassages = $db->prepare("SELECT * FROM nfc_log WHERE id_bien = :id_bien ORDER BY log_date_time DESC");
    $stmtPassages->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmtPassages->execute();
    $passages = $stmtPassages->fetchAll(PDO::FETCH_ASSOC);

    function getPrestataire($db, $nfc_id){
        $getUser = $db->prepare("SELECT * FROM utilisateur WHERE nfc_id = :nfc_id");
        $getUser->bindParam(':nfc_id', $nfc_id, PDO::PARAM_INT);
        $getUser->execute();
        $user = $getUser->fetchAll(PDO::FETCH_ASSOC);
        return $user[0];
    }

    $stmtReservations = $db->prepare("SELECT * FROM occupation WHERE id_bien = :id_bien LIMIT 5");
    $stmtReservations->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmtReservations->execute();
    $reservations = $stmtReservations->fetchAll(PDO::FETCH_ASSOC);

    
    $stmtInterventions = $db->prepare("SELECT * FROM prestation_commande WHERE id_bien = :id_bien LIMIT 5");
    $stmtInterventions->bindParam(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmtInterventions->execute();
    $interventions = $stmtInterventions->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Détails du bien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .photos-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .photo-item {
            flex: 0 0 calc(20% - 10px);
            max-width: calc(20% - 10px);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.1);
        }
        .photo-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .table-container {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .table th, .table td {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="row">
            <div class="col-md-6 text-md-left">
                <a href="biens.php" class="btn btn-secondary">Retour à la liste des biens</a>
            </div>
            <div class="col-md-6 text-md-center">
                <a href="modifier_bien.php?id=<?php echo $id_bien; ?>" class="btn btn-primary">Modifier</a>
            </div>
        </div>
        <h1 class="mt-4 mb-4">Détails du bien</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Titre :</strong> <?php echo isset($bien['title']) ? htmlspecialchars($bien['title']) : "Non spécifié"; ?></p>
                <p><strong>Description :</strong> <br><?php echo isset($bien['description']) ? nl2br(htmlspecialchars($bien['description'])) : "Non spécifiée"; ?></p>
                <p><strong>Adresse :</strong> <?php echo isset($bien['address']) ? htmlspecialchars($bien['address']) : "Non spécifiée"; ?>, <?php echo isset($bien['code_postal']) ? htmlspecialchars($bien['code_postal']) : "Non spécifié"; ?> <?php echo isset($bien['city']) ? htmlspecialchars($bien['city']) : "Non spécifiée"; ?></p>
                <p><strong>Type de bien :</strong> <?php echo isset($bien['type_bien']) ? htmlspecialchars($bien['type_bien']) : "Non spécifié"; ?></p>
                <p><strong>Prix :</strong> <?php echo isset($bien['prix']) ? htmlspecialchars(number_format($bien['prix'], 2, ',', ' ')) . " €" : "Non spécifié"; ?></p>
                <p><strong>Meublé :</strong> <?php echo isset($bien['meuble']) && $bien['meuble'] == 1 ? 'Oui' : 'Non'; ?></p>
                <p><strong>Durée de location :</strong> <?php echo isset($bien['duree_location']) ? htmlspecialchars($bien['duree_location']) : "Non spécifiée"; ?></p>
                <p><strong>Nombre de personnes maximum :</strong> <?php echo isset($bien['nbr_personne_max']) ? htmlspecialchars($bien['nbr_personne_max']) : "Non spécifié"; ?></p>
                <p><strong>Superficie :</strong> <?php echo isset($bien['superficie']) ? htmlspecialchars(number_format($bien['superficie'], 2, ',', ' ')) . " m²" : "Non spécifiée"; ?></p>
                <p><strong>Date de création :</strong> <?php echo isset($bien['creation']) ? htmlspecialchars($bien['creation']) : "Non spécifiée"; ?></p>
                <p><strong>Dernière mise à jour :</strong> <?php echo isset($bien['maj']) ? htmlspecialchars($bien['maj']) : "Non spécifiée"; ?></p>
                <p><strong>Réfus par le bot :</strong> <?php echo isset($bien['refus_bot']) && $bien['refus_bot'] == 1 ? 'Oui' : 'Non'; ?></p>
                <?php if (!empty($bien['raison_refus'])): ?>
                    <p><strong>Raison du refus :</strong> <?php echo htmlspecialchars($bien['raison_refus']); ?></p>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <h2 class="mb-4">Photos du bien</h2>
                <div id="carouselBien" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($photos as $index => $photo): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="../photo/<?php echo htmlspecialchars($photo['url']); ?>" class="d-block w-100" alt="Photo du bien">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselBien" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselBien" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <?php if ($bailleur): ?>
                    <h2 class="mb-4">Bailleur</h2>
                    <p><strong>Nom :</strong> <?php echo isset($bailleur['nom']) ? htmlspecialchars($bailleur['nom']) : "Non spécifié"; ?></p>
                    <p><strong>Prénom :</strong> <?php echo isset($bailleur['prenom']) ? htmlspecialchars($bailleur['prenom']) : "Non spécifié"; ?></p>
                    <p><strong>Email :</strong> <?php echo isset($bailleur['email']) ? htmlspecialchars($bailleur['email']) : "Non spécifié"; ?></p>
                <?php else: ?>
                    <p>Aucune information sur le bailleur trouvée.</p>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <?php if ($admin): ?>
                    <h2 class="mb-4">Administrateur ayant validé</h2>
                    <p><strong>Nom :</strong> <?php echo isset($admin['nom']) ? htmlspecialchars($admin['nom']) : "Non spécifié"; ?></p>
                    <p><strong>Prénom :</strong> <?php echo isset($admin['prenom']) ? htmlspecialchars($admin['prenom']) : "Non spécifié"; ?></p>
                    <p><strong>Email :</strong> <?php echo isset($admin['email']) ? htmlspecialchars($admin['email']) : "Non spécifié"; ?></p>
                <?php else: ?>
                    <p>Aucune information sur l'administrateur ayant validé trouvée.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-12">
            <div class="col-md-12">
                <h2 class="mb-4">Passages des prestataires <a href="passage.php?id_bien=<?= $id_bien ?>">details</a></h2>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Prestataire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($passages as $passage): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($passage['id_log']); ?></td>
                                    <td><?php echo htmlspecialchars($passage['log_date_time']); ?></td>
                                    <td><a href="pdetails.php?id=<?= getPrestataire($db, $passage['nfc_id'])['id_utilisateur'] ?>"><?= htmlspecialchars(getPrestataire($db, $passage['nfc_id'])['nom']) ?> <?= htmlspecialchars(getPrestataire($db, $passage['nfc_id'])['prenom']) ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h2 class="mb-4">Réservations <a href="reservation.php?id_bien=<?= $id_bien ?>">details</a></h2>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['date_debut']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['date_fin']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h2 class="mb-4">Interventions</h2>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Prestataire</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($interventions as $intervention): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($intervention['id']); ?></td>
                                    <td><?php echo htmlspecialchars($intervention['date']); ?></td>
                                    <td><?php echo htmlspecialchars($intervention['prestataire']); ?></td>
                                    <td>
                                        <a href="details.php?id=<?php echo htmlspecialchars($intervention['id']); ?>" class="btn btn-primary">Voir Détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
