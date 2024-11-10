<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page voyageur id " . $_GET["id"]);

if(!isset($_GET['id']) && empty($_GET['id'])) {
    logActivity("", "page detail voyageur id non informer");
    header("Location: voyageurs.php?msg=Erreur id non trouvé.&err=true");
    exit();
}

$bailleurId = htmlspecialchars($_GET["id"]);

$db = getDatabase();

$getBailleur = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
$getBailleur->execute([$bailleurId]);
$bailleur = $getBailleur->fetch(PDO::FETCH_ASSOC);

if(!$bailleur) {
    logActivity("", "page detail voyageur id " . $_GET["id"] . " non trouvé");
    header("Location: voyageurs.php?msg=Utilisateur non trouvé.&err=true");
    exit();
}

$genre = ($bailleur['genre'] == 0) ? 'Homme' : 'Femme';

if ($bailleur["bloque"] != null) {
    $status = "Bloqué le " . $bailleur["bloque"];
    $reason = ($bailleur["raison_refus"]) ? $bailleur["raison_refus"] : "";
} else {
    $status = "Validé";
    $reason = "";
}

if ($bailleur["bloque"] == null){
    $buttons = '
    <div class="mt-3">
        <a href="bloque_voyageur.php?id='.$bailleur['id_utilisateur'].'" class="btn btn-danger mr-2">Bloquer</a>
        <a href="voyageurs.php" class="btn btn-secondary mr-2 ">Retour</a>
    </div>
    ';
} else {
    $buttons = '
    <div class="mt-3">
        <a href="voyageurs.php" class="btn btn-secondary mr-2 ">Retour</a>
    </div>
    ';
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du voyageur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .card-text {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
        <?php

        if (isset($_GET["msg"]) && $_GET["err"] == 'true'){
            echo '
            <div class="alert alert-danger" role="alert">
                '. $_GET["msg"] .'
            </div>
            ';
        } elseif (isset($_GET["msg"]) && $_GET["err"] == 'false') {
            echo '
            <div class="alert alert-success" role="alert">
                '. $_GET["msg"] .'
            </div>
            ';
        }

        ?>
            <div class="card">
                <div class="card-header">
                    Détails du voyageur
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $bailleur['prenom'] . ' ' . $bailleur['nom']; ?></h5>
                    <p class="card-text"><strong>Genre :</strong> <?php echo $genre; ?></p>
                    <p class="card-text"><strong>Email :</strong> <?php echo $bailleur['email']; ?></p>
                    <p class="card-text"><strong>Date de naissance :</strong> <?php echo $bailleur['date_naissance']; ?></p>
                    <p class="card-text"><strong>Numéro de téléphone :</strong> <?php echo $bailleur['numero_telephone']; ?></p>
                    <p class="card-text"><strong>Pays du téléphone :</strong> <?php echo $bailleur['pays_telephone']; ?></p>
                    <p class="card-text"><strong>Date d'inscription :</strong> <?php echo $bailleur['date_inscription']; ?></p>
                    <p class="card-text"><strong>Status :</strong> <?php echo $status; ?></p>
                    <?php if ($bailleur['bloque'] != null): ?>
                        <p class="card-text"><strong>Raison du blocage :</strong> <?php echo $reason; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?=$buttons?>
        </div>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
