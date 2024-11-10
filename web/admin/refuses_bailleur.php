<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");

// Vérifie si l'ID du bailleur a été envoyé en POST
if(isset($_POST["id"])) {
    $bailleur_id = htmlspecialchars($_POST["id"]);

    $db = getDatabase();

    // Récupère les informations du bailleur en attente avec l'ID spécifié
    $getBailleur = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ? AND bailleur IS NOT NULL");
    $getBailleur->execute([$bailleur_id]);
    $bailleur = $getBailleur->fetch(PDO::FETCH_ASSOC);

    // Vérifie si le bailleur a été trouvé
    if($bailleur) {
        logActivity("", "page refuse bailleur de " . $bailleur_id);
    } else {
        // Redirectionne vers une page d'erreur si le bailleur n'est pas trouvé
        header("Location: error.php");
        exit; // Arrête l'exécution du script pour éviter toute autre sortie
    }
} else {
    // Redirectionne vers une page d'erreur si l'ID du bailleur n'est pas fourni
    header("Location: error.php");
    exit; // Arrête l'exécution du script pour éviter toute autre sortie
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refus bailleur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Bailleur en attente :</h2>
                <ul>
                    <li>Nom : <?= $bailleur['nom'] ?></li>
                    <li>Prénom : <?= $bailleur['prenom'] ?></li>
                    <li>Email : <?= $bailleur['email'] ?></li>
                    <!-- Ajoutez d'autres informations du bailleur ici -->
                </ul>
                <form action="process/refuses_bailleur.php" method="POST">
                    <input type="hidden" name="id" value="<?= $bailleur_id ?>">
                    <div class="form-group">
                        <label for="reason">Raison du refus :</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Refuser le bailleur</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
