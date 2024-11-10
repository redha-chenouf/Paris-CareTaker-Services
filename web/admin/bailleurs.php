<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page bailleurs.php");

include("function.php");

$db = getDatabase();

$getBailleurAll = $db->prepare("SELECT * FROM utilisateur WHERE bailleur_accept = 1 OR bailleur_accept = 0 OR bailleur_refus = 1 OR bailleur_refus = 0");
$getBailleurAll->execute([]);
$bailleurAll = $getBailleurAll->fetchAll(PDO::FETCH_ASSOC);

$getBailleurAccept = $db->prepare("SELECT * FROM utilisateur WHERE bailleur_accept = 1 AND bailleur_refus = 0");
$getBailleurAccept->execute([]);
$bailleurAccept = $getBailleurAccept->fetchAll(PDO::FETCH_ASSOC);

$getBailleurWaiting = $db->prepare("SELECT * FROM utilisateur WHERE bailleur_accept = 0 AND bailleur_refus = 0");
$getBailleurWaiting->execute([]);
$bailleurWaiting = $getBailleurWaiting->fetchAll(PDO::FETCH_ASSOC);

$getBailleurRefuses = $db->prepare("SELECT * FROM utilisateur WHERE bailleur_accept = 0 AND bailleur_refus = 1");
$getBailleurRefuses->execute([]);
$bailleurRefuses = $getBailleurRefuses->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailleurs status</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?php
        if (isset($_GET["msg"]) && isset($_GET["err"])){
            displayError($_GET["msg"], $_GET["err"]);
        }
    ?>
    
    <div class="d-flex justify-content-center mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" id="all-tab" data-bs-toggle="tab" href="#all">Tout les bailleurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="acceptes-tab" data-bs-toggle="tab" href="#acceptes">Acceptés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attente-tab" data-bs-toggle="tab" href="#attente">En attente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="refuses-tab" data-bs-toggle="tab" href="#refuses">Refusés</a>
            </li>
        </ul>
    </div>


    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all">
                        <div class="search-bar mb-4">
                            <input type="text" id="searchInputAll" class="form-control" placeholder="Rechercher...">
                        </div>
                        <h2>Tout les bailleurs</h2>
                        <div class="table-responsive">
                            <table class="table table-striped" id="searchResults">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Status</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurAll as $bailleur) {
                                        if ($bailleur["bailleur_accept"] == 1 && $bailleur["bailleur_refus"] == 0) {
                                            $status = "Accepté";
                                        } else if ($bailleur["bailleur_accept"] == 0 && $bailleur["bailleur_refus"] == 0) {
                                            $status = "En attente";
                                        } else if ($bailleur["bailleur_accept"] == 0 && $bailleur["bailleur_refus"] == 1) {
                                            $status = "Refusé";
                                        } else {
                                            $status = "";
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td>" . $status . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="acceptes">
                        <h2>Bailleurs acceptés</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurAccept as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="attente">
                    <h2>Bailleurs en attente</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurWaiting as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="refuses">
                        <h2>Bailleurs refusés</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Numéro pays</th>
                                        <th>Numéro téléphone</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bailleurRefuses as $bailleur) {
                                        echo "<tr>";
                                        echo "<td>" . $bailleur['nom'] . "</td>";
                                        echo "<td>" . $bailleur['prenom'] . "</td>";
                                        echo "<td>" . $bailleur['email'] . "</td>";
                                        echo "<td>" . $bailleur['pays_telephone'] . "</td>";
                                        echo "<td>" . $bailleur['numero_telephone'] . "</td>";
                                        echo "<td><a href='bdetails.php?id=" . $bailleur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <?php searchFunction("searchInputAll", "process/search.php", "bailleur") ?>

</body>
</html>
