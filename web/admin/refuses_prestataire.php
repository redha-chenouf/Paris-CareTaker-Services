<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");

// Vérifie si l'ID du prestataire a été envoyé en GET
if(isset($_GET["id"])) {
    $prestataire_id = htmlspecialchars($_GET["id"]);

    $db = getDatabase();

    // Récupère les informations du prestataire en attente avec l'ID spécifié
    $getPrestataire = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
    $getPrestataire->execute([$prestataire_id]);
    $prestataire = $getPrestataire->fetch(PDO::FETCH_ASSOC);

} else {
    header("Location: prestataires.php?msg=Une erreur s'est produite.&err=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refus prestataire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Prestataire en attente :</h2>
                <ul>
                    <li>Nom : <?= $prestataire['nom'] ?></li>
                    <li>Prénom : <?= $prestataire['prenom'] ?></li>
                    <li>Email : <?= $prestataire['email'] ?></li>
                </ul>
                <form action="process/refuses_prestataire.php" method="POST">
                    <input type="hidden" name="id" value="<?= $prestataire_id ?>">
                    <div class="form-group">
                        <label for="reason">Raison du refus :</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Refuser le prestataire</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
