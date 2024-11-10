<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page index.php");

$db = getDatabase();

// Partie Bailleur
$getBailleurAccept = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE bailleur_accept = 1 AND bailleur IS NOT NULL AND bailleur_refus = 0");
$getBailleurAccept->execute([]);
$bailleurAccept = $getBailleurAccept->fetchAll(PDO::FETCH_ASSOC);
$bailleurAccept = $bailleurAccept[0]['COUNT(id_utilisateur)'];

$getBailleurWaiting = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE bailleur_accept = 0 AND bailleur_refus = 0");
$getBailleurWaiting->execute([]);
$bailleurWaiting = $getBailleurWaiting->fetchAll(PDO::FETCH_ASSOC);
$bailleurWaiting = $bailleurWaiting[0]['COUNT(id_utilisateur)'];

$getBailleurRefuse = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE bailleur_refus = 1");
$getBailleurRefuse->execute([]);
$bailleurRefuse = $getBailleurRefuse->fetchAll(PDO::FETCH_ASSOC);
$bailleurRefuse = $bailleurRefuse[0]['COUNT(id_utilisateur)'];

// Partie Voyageur
$getVoyageurValide = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE voyageur IS NOT NULL AND bloque IS NULL");
$getVoyageurValide->execute([]);
$voyageurValide = $getVoyageurValide->fetchAll(PDO::FETCH_ASSOC);
$voyageurValide = $voyageurValide[0]['COUNT(id_utilisateur)'];

$getVoyageurBloque = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE bloque IS NOT NULL AND voyageur IS NOT NULL");
$getVoyageurBloque->execute([]);
$bailleurBloque = $getVoyageurBloque->fetchAll(PDO::FETCH_ASSOC);
$bailleurBloque = $bailleurBloque[0]['COUNT(id_utilisateur)'];

// Partie Prestataire
$getPrestataireAccept = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE prestataire_accept = 1 AND prestataire IS NOT NULL AND prestataire_refus = 0");
$getPrestataireAccept->execute([]);
$prestataireAccept = $getPrestataireAccept->fetchAll(PDO::FETCH_ASSOC);
$prestataireAccept = $prestataireAccept[0]['COUNT(id_utilisateur)'];

$getPrestataireWaiting = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE prestataire_accept = 0 AND prestataire_refus = 0");
$getPrestataireWaiting->execute([]);
$prestataireWaiting = $getPrestataireWaiting->fetchAll(PDO::FETCH_ASSOC);
$prestataireWaiting = $prestataireWaiting[0]['COUNT(id_utilisateur)'];

$getPrestataireRefuse = $db->prepare("SELECT COUNT(id_utilisateur) FROM utilisateur WHERE prestataire_refus = 1");
$getPrestataireRefuse->execute([]);
$prestataireRefuse = $getPrestataireRefuse->fetchAll(PDO::FETCH_ASSOC);
$prestataireRefuse = $prestataireRefuse[0]['COUNT(id_utilisateur)'];

// Partie Bien
$acceptBien = $db->prepare("SELECT COUNT(id_bien) FROM bien WHERE id_administrateur IS NOT NULL AND raison_refus IS NULL AND refus_bot = 0");
$acceptBien->execute([]);
$bienAccept = $acceptBien->fetchAll(PDO::FETCH_ASSOC);
$bienAccept = $bienAccept[0]['COUNT(id_bien)'];

$pendingBien = $db->prepare("SELECT COUNT(id_bien) FROM bien WHERE id_administrateur IS NULL AND raison_refus IS NULL AND refus_bot = 0");
$pendingBien->execute([]);
$bienPending = $pendingBien->fetchAll(PDO::FETCH_ASSOC);
$bienPending = $bienPending[0]['COUNT(id_bien)'];

$refusBot = $db->prepare("SELECT COUNT(id_bien) FROM bien WHERE id_administrateur IS NULL AND refus_bot = 1");
$refusBot->execute([]);
$bienRefusBot = $refusBot->fetchAll(PDO::FETCH_ASSOC);
$bienRefusBot = $bienRefusBot[0]['COUNT(id_bien)'];

$refusAdmin = $db->prepare("SELECT COUNT(id_bien) FROM bien WHERE id_administrateur IS NOT NULL AND raison_refus IS NOT NULL");
$refusAdmin->execute([]);
$bienRefusAdmin = $refusAdmin->fetchAll(PDO::FETCH_ASSOC);
$bienRefusAdmin = $bienRefusAdmin[0]['COUNT(id_bien)'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <?= displayIcon("") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    canvas {
      margin: 20px;
    }
  </style>
</head>
<body>

<div class="container mt-5 mb-5">
  <h2 class="mb-4">Tableau de bord</h2>

  <div class="d-none d-md-block">
    <div class="row row-cols-md-2">
      <div class="col">
        <a href="bailleurs.php">
          <canvas id="bailleursChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="biens.php">
          <canvas id="biensChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="voyageurs.php">
          <canvas id="voyageursChart" width="400" height="300"></canvas>
        </a>
      </div>
      <div class="col">
        <a href="prestataires.php">
          <canvas id="prestatairesChart" width="400" height="300"></canvas>
        </a>
      </div>
    </div>
  </div>

  <div class="d-md-none">
    <p class="text-center">Les graphiques ne sont pas disponibles sur les téléphones.</p>
  </div>

</div>

<script>
  // Données pour les graphiques
  const bailleursData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Bailleurs (' + (<?=$bailleurAccept?> + <?=$bailleurWaiting?> + <?=$bailleurRefuse?>) + ')',
      data: [<?=$bailleurAccept?>, <?=$bailleurWaiting?>, <?=$bailleurRefuse?>],
      backgroundColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 206, 86, 0.2)',
      ],
      borderColor: [
        'rgba(54, 162, 235, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 206, 86, 1)',
      ],
      borderWidth: 1
    }]
  };

  const biensData = {
    labels: ['Validés', 'En attente', 'Refusés par bot', 'Refusés par admin'],
    datasets: [{
      label: 'Biens (' + (<?=$bienAccept?> + <?=$bienPending?> + <?=$bienRefusBot?> + <?=$bienRefusAdmin?>) + ')',
      data: [<?=$bienAccept?>, <?=$bienPending?>, <?=$bienRefusBot?>, <?=$bienRefusAdmin?>],
      backgroundColor: [
        'rgba(75, 192, 192, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 99, 132, 0.2)',
      ],
      borderColor: [
        'rgba(75, 192, 192, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 99, 132, 1)',
      ],
      borderWidth: 1
    }]
  };

  const voyageursData = {
    labels: ['Valide', 'Bloqué'],
    datasets: [{
      label: 'Voyageurs (' + (<?=$voyageurValide?> + <?=$bailleurBloque?>) + ')',
      data: [<?=$voyageurValide?>, <?=$bailleurBloque?>],
      backgroundColor: [
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgba(255, 205, 86, 1)',
        'rgba(75, 192, 192, 1)',
      ],
      borderWidth: 1
    }]
  };

  const prestatairesData = {
    labels: ['Validés', 'En attente', 'Refusés'],
    datasets: [{
      label: 'Prestataires (' + (<?=$prestataireAccept?> + <?=$prestataireWaiting?> + <?=$prestataireRefuse?>) + ')',
      data: [<?=$prestataireAccept?>, <?=$prestataireWaiting?>, <?=$prestataireRefuse?>],
      backgroundColor: [
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(75, 192, 192, 1)',
      ],
      borderWidth: 1
    }]
  };

  // Configuration des options de graphique
  const options = {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  };

  // Création des graphiques
  var bailleursChart = new Chart(document.getElementById('bailleursChart'), {
    type: 'bar',
    data: bailleursData,
    options: options
  });

  var biensChart = new Chart(document.getElementById('biensChart'), {
    type: 'bar',
    data: biensData,
    options: options
  });

  var voyageursChart = new Chart(document.getElementById('voyageursChart'), {
    type: 'bar',
    data: voyageursData,
    options: options
  });

  var prestatairesChart = new Chart(document.getElementById('prestatairesChart'), {
    type: 'bar',
    data: prestatairesData,
    options: options
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
