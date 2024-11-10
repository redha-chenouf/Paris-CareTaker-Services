<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page voyageurs.php");

include("function.php");

$db = getDatabase();

$getVoyageurAll = $db->prepare("SELECT * FROM utilisateur WHERE voyageur IS NOT NULL");
$getVoyageurAll->execute([]);
$voyageurAll = $getVoyageurAll->fetchAll(PDO::FETCH_ASSOC);

$getvoyageurAccept = $db->prepare("SELECT * FROM utilisateur WHERE bloque IS NULL AND voyageur IS NOT NULL");
$getvoyageurAccept->execute([]);
$voyageurAccept = $getvoyageurAccept->fetchAll(PDO::FETCH_ASSOC);

$getvoyageurBloque = $db->prepare("SELECT * FROM utilisateur WHERE bloque IS NOT NULL AND voyageur IS NOT NULL");
$getvoyageurBloque->execute([]);
$voyageurBloque = $getvoyageurBloque->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyageurs status</title>
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
                <a class="nav-link active" aria-current="page" id="all-tab" data-bs-toggle="tab" href="#all">Tout les voyageurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="acceptes-tab" data-bs-toggle="tab" href="#acceptes">Valide</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attente-tab" data-bs-toggle="tab" href="#attente">Bloqué</a>
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
                        <h2>Tout les voyageurs</h2>
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
                                    foreach ($voyageurAll as $voyageur) {
                                        if ($voyageur["bloque"] != null) {
                                            $status = "Bloqué";
                                        } else {
                                            $status = "Valide";
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $voyageur['nom'] . "</td>";
                                        echo "<td>" . $voyageur['prenom'] . "</td>";
                                        echo "<td>" . $voyageur['email'] . "</td>";
                                        echo "<td>" . $voyageur['pays_telephone'] . "</td>";
                                        echo "<td>" . $voyageur['numero_telephone'] . "</td>";
                                        echo "<td>" . $status . "</td>";
                                        echo "<td><a href='vdetails.php?id=" . $voyageur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="acceptes">
                        <h2>Voyageurs valide</h2>
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
                                    foreach ($voyageurAccept as $voyageur) {
                                        echo "<tr>";
                                        echo "<td>" . $voyageur['nom'] . "</td>";
                                        echo "<td>" . $voyageur['prenom'] . "</td>";
                                        echo "<td>" . $voyageur['email'] . "</td>";
                                        echo "<td>" . $voyageur['pays_telephone'] . "</td>";
                                        echo "<td>" . $voyageur['numero_telephone'] . "</td>";
                                        echo "<td><a href='vdetails.php?id=" . $voyageur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="attente">
                    <h2>Voyageurs bloqué</h2>
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
                                    foreach ($voyageurBloque as $voyageur) {
                                        echo "<tr>";
                                        echo "<td>" . $voyageur['nom'] . "</td>";
                                        echo "<td>" . $voyageur['prenom'] . "</td>";
                                        echo "<td>" . $voyageur['email'] . "</td>";
                                        echo "<td>" . $voyageur['pays_telephone'] . "</td>";
                                        echo "<td>" . $voyageur['numero_telephone'] . "</td>";
                                        echo "<td><a href='vdetails.php?id=" . $voyageur['id_utilisateur'] . "' class='btn btn-primary'>Détails</a></td>";
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

    <?php searchFunction("searchInputAll", "process/searchVoyageurs.php", "voyageur") ?>

</body>
</html>
