<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page prestataire id " . $_GET["id"]);

if(!isset($_GET['id']) && empty($_GET['id'])) {
    logActivity("", "page detail prestataire id non informé");
    header("Location: prestataires.php?msg=Erreur: ID non trouvé.&err=true");
    exit();
}

$prestataireId = htmlspecialchars($_GET["id"]);

$db = getDatabase();

$getPrestataire = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ? AND prestataire IS NOT NULL");
$getPrestataire->execute([$prestataireId]);
$prestataire = $getPrestataire->fetch(PDO::FETCH_ASSOC);

if(!$prestataire) {
    logActivity("", "page detail prestataire id " . $_GET["id"] . " non trouvé");
    header("Location: prestataires.php?msg=Utilisateur non trouvé.&err=true");
    exit();
}

$genre = ($prestataire['genre'] == 0) ? 'Homme' : 'Femme';

if ($prestataire["prestataire_refus"] == 1) {
    $status = "Refusé";
    $reason = $prestataire["raison_refus"];
} else {
    $status = "Accepté";
    $reason = "";
}

if ($prestataire["prestataire_refus"] == 1 && $prestataire["prestataire_accept"] == 0) {
    $buttons = '<a href="process/accept_prestataire.php?id='. $prestataireId .'" class="btn btn-success mr-2">Accepter</a>
                <a href="prestataires.php" class="btn btn-secondary mr-2">Retour</a>';
} else if ($prestataire["prestataire_refus"] == 0 && $prestataire["prestataire_accept"] == 0) {
    $buttons = '<a href="process/accept_prestataire.php?id='. $prestataireId .'" class="btn btn-success mr-2">Accepter</a>
                <a href="refuses_prestataire.php?id='. $prestataireId .'" class="btn btn-danger mr-2">Refuser</a>
                <a href="prestataires.php" class="btn btn-secondary mr-2">Retour</a>';
} else if ($prestataire["prestataire_refus"] == 0 && $prestataire["prestataire_accept"] == 1) {
    $buttons = '<a href="refuses_prestataire.php?id='. $prestataireId .'" class="btn btn-danger mr-2">Refuser</a>
                <a href="prestataires.php" class="btn btn-secondary mr-2">Retour</a>';
} else {
    $buttons = '<a href="prestataires.php" class="btn btn-secondary mr-2">Retour</a>';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du prestataire</title>
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
                    Détails du prestataire
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $prestataire['prenom'] . ' ' . $prestataire['nom']; ?></h5>
                    <p class="card-text"><strong>Email :</strong> <?php echo $prestataire['email']; ?></p>
                    <p class="card-text"><strong>Numéro de téléphone :</strong> <?php echo $prestataire['numero_telephone']; ?></p>
                    <p class="card-text"><strong>Pays du téléphone :</strong> <?php echo $prestataire['pays_telephone']; ?></p>
                    <p class="card-text"><strong>NFC ID : </strong><a href="nfc.php?id=<?= $prestataire['nfc_id']?>"><?php echo $prestataire['nfc_id']; ?></a></p>
                    <p class="card-text"><strong>Status :</strong> <?php echo $status; ?></p>
                    <?php if ($prestataire["prestataire_refus"] == 1): ?>
                        <p class="card-text"><strong>Raison du refus :</strong> <?php echo $reason; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-3">
                <?= $buttons ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
