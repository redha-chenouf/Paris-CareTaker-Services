<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");

$db = getDatabase();

$id_bien = isset($_GET['id_bien']) ? intval($_GET['id_bien']) : 0;

if ($id_bien > 0) {
    $sql = "SELECT * FROM nfc_log WHERE id_bien = :id_bien ORDER BY log_date_time DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id_bien', $id_bien, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo "<div class='container mt-5'>";
        echo "<h2>Logs for Bien ID: " . $id_bien . "</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>ID Log</th><th>NFC ID</th><th>Date and Time</th><th>Bien ID</th></tr></thead>";
        echo "<tbody>";
        foreach($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id_log'] . "</td>";
            echo "<td><a href='nfc.php?id=". $row['nfc_id'] ."'>" . $row['nfc_id'] . "</a></td>";
            echo "<td>" . $row['log_date_time'] . "</td>";
            echo "<td><a href='bien.php?id=". $row['id_bien'] ."'>" . $row['id_bien'] . "</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><div class='alert alert-warning' role='alert'>No logs found for Bien ID: $id_bien</div></div>";
    }
} else {
    echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>Invalid Bien ID</div></div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC Log Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
