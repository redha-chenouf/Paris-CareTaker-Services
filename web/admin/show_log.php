<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page show_login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h1>Vos Logs</h1>

        <!-- Barre de recherche -->
        <div class="input-group search-bar">
            <input type="text" class="form-control" id="searchInput" placeholder="Rechercher dans les logs..." aria-label="Rechercher dans les logs" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">Rechercher</button>
            </div>
        </div>

        <!-- Affichage du nombre de lignes -->
        <div class="form-group">
            <label for="lineCount">Nombre de lignes à afficher :</label>
            <select class="form-control" id="lineCount">
                <option value="5">5 lignes</option>
                <option value="10">10 lignes</option>
                <option value="20">20 lignes</option>
                <option value="50">50 lignes</option>
                <option value="100">100 lignes</option>
                <option value="all">Toutes les lignes</option>
            </select>
        </div>

        <!-- Affichage des logs -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Adresse IP</th>
                        <th>Date / Heure</th>
                        <th>ID Administrateur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    <?php
                    // Chemin du fichier de logs
                    $log_file = "logs/activity_log_" . $_SESSION["admin_id"] . ".txt";

                    // Vérification de l'existence du fichier
                    if (file_exists($log_file)) {
                        // Lecture du contenu du fichier de logs
                        $logs = file($log_file, FILE_IGNORE_NEW_LINES);

                        // Inverser l'ordre des lignes
                        $logs = array_reverse($logs);

                        // Affichage des logs
                        foreach ($logs as $log) {
                            // Séparation des informations par des tirets
                            $log_info = explode("-", $log);
                            echo "<tr>";
                            echo "<td>" . $log_info[0] . "</td>";
                            echo "<td>" . $log_info[1] . "</td>";
                            echo "<td>" . $log_info[2] . "</td>";
                            echo "<td>" . $log_info[3] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Aucun log disponible pour le moment.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $("#searchButton").click(function(){
                var searchText = $("#searchInput").val().trim().toLowerCase();
                $("#logTableBody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1)
                });
            });

            $("#lineCount").change(function(){
                var count = $(this).val();
                if(count == "all") {
                    $("#logTableBody tr").show();
                } else {
                    $("#logTableBody tr").hide();
                    $("#logTableBody tr:lt(" + count + ")").show();
                }
            });
        });
    </script>
</body>
</html>
