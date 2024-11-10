<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page bailleur id " . $_GET["id"]);

if(!isset($_GET['id']) && empty($_GET['id'])) {
    logActivity("", "page detail bailleur id non informer");
    header("Location: bailleurs.php?msg=Erreur id non trouvé.&err=true");
    exit();
}

$bailleurId = htmlspecialchars($_GET["id"]);

$db = getDatabase();

$getBailleur = $db->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ? AND bailleur IS NOT NULL");
$getBailleur->execute([$bailleurId]);
$bailleur = $getBailleur->fetch(PDO::FETCH_ASSOC);

if(!$bailleur) {
    logActivity("", "page detail bailleur id " . $_GET["id"] . " non trouvé");
    header("Location: bailleurs.php?msg=Utilisateur non trouvé.&err=true");
    exit();
}

$genre = ($bailleur['genre'] == 0) ? 'Homme' : 'Femme';

if ($bailleur["bailleur_accept"] == 0 && $bailleur["bailleur_refus"] == 0){
    $buttons = '
    <div class="mt-3">
        <form action="process/accept_bailleur.php" method="POST" class="d-inline">
            <input type="hidden" name="id" value="' . $bailleur['id_utilisateur'] . '">
            <button type="submit" class="btn btn-success mr-2">Accepter</button>
        </form>
        <form action="refuses_bailleur.php" method="POST" class="d-inline">
            <input type="hidden" name="id" value=' . $bailleur['id_utilisateur'] . '">
            <button type="submit" class="btn btn-danger mr-2">Refuser</button>
        </form>
        <a href="bailleurs.php" class="btn btn-secondary mr-2 ">Retour</a>
    </div>
    ';
} elseif ($bailleur["bailleur_accept"] == 1 && $bailleur["bailleur_refus"] == 0) {
    $buttons = '
    <div class="mt-3">
        <form action="refuses_bailleur.php" method="POST" class="d-inline">
            <input type="hidden" name="id" value="'. $bailleur['id_utilisateur'] .'">
            <button type="submit" class="btn btn-danger mr-2">Refuser</button>
        </form>
        <a href="bailleurs.php" class="btn btn-secondary mr-2">Retour</a>
    </div>
    ';
} elseif ($bailleur["bailleur_accept"] == 0 && $bailleur["bailleur_refus"] == 1) {
    $buttons = '
    <div class="mt-3">
        <form action="process/accept_bailleur.php" method="POST" class="d-inline">
            <input type="hidden" name="id" value="'. $bailleur['id_utilisateur'] .'">
            <button type="submit" class="btn btn-success mr-2">Accepter</button>
        </form>
        <a href="bailleurs.php" class="btn btn-secondary mr-2">Retour</a>
    </div>
    ';
} else {
    $buttons = '
    <div class="mt-3">
        <a href="bailleurs.php" class="btn btn-secondary mr-2">Retour</a>
    </div>
    ';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du bailleur</title>
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
                    Détails du bailleur
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $bailleur['prenom'] . ' ' . $bailleur['nom']; ?></h5>
                    <p class="card-text"><strong>Genre :</strong> <?php echo ($bailleur['genre'] == 0) ? 'Homme' : 'Femme'; ?></p>
                    <p class="card-text"><strong>Email :</strong> <?php echo $bailleur['email']; ?></p>
                    <p class="card-text"><strong>Date de naissance :</strong> <?php echo $bailleur['date_naissance']; ?></p>
                    <p class="card-text"><strong>Numéro de téléphone :</strong> <?php echo $bailleur['numero_telephone']; ?></p>
                    <p class="card-text"><strong>Pays du téléphone :</strong> <?php echo $bailleur['pays_telephone']; ?></p>
                    <p class="card-text"><strong>Date d'inscription :</strong> <?php echo $bailleur['date_inscription']; ?></p>
                    <p class="card-text"><strong>Code banque :</strong> <?php echo $bailleur['code_banque']; ?></p>
                    <p class="card-text"><strong>Code guichet :</strong> <?php echo $bailleur['code_guichet']; ?></p>
                    <p class="card-text"><strong>Numéro de compte :</strong> <?php echo $bailleur['numero_de_compte']; ?></p>
                    <p class="card-text"><strong>Clé RIB :</strong> <?php echo $bailleur['cle_rib']; ?></p>
                    <p class="card-text"><strong>IBAN :</strong> <?php echo $bailleur['iban']; ?></p>
                    <p class="card-text"><strong>BIC/SWIFT :</strong> <?php echo $bailleur['bic']; ?></p>
                    <p class="card-text"><strong>URL RIB :</strong> <?php echo $bailleur['url_rib']; ?></p>
                    <p class="card-text"><strong>Accepté :</strong> <?php echo ($bailleur['bailleur_accept'] == 1) ? 'Oui' : 'Non'; ?></p>
                    <p class="card-text"><strong>Refusé :</strong> <?php echo ($bailleur['bailleur_refus'] == 1) ? 'Oui' : 'Non'; ?></p>
                    <?php if ($bailleur['bailleur_refus'] == 1): ?>
                        <p class="card-text"><strong>Raison du refus :</strong> <?php echo $bailleur['raison_refus']; ?></p>
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
