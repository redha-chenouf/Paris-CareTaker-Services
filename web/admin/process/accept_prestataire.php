<?php
include("../include/utils.php");
checkSessionElseLogin("../");

include("../log.php");

if(isset($_GET["id"])) {
    $prestataire_id = htmlspecialchars($_GET["id"]);

    logActivity("../", "Page acceptation prestataire ID " . $prestataire_id);

    $db = getDatabase();

    $updatePrestataire = $db->prepare("UPDATE utilisateur SET prestataire_accept = 1, prestataire_refus = 0 WHERE id_utilisateur = ?");
    $updatePrestataire->execute([$prestataire_id]);
    $rowsAffected = $updatePrestataire->rowCount();

    if ($rowsAffected > 0) {
        logActivity("../", "Prestataire ID " . $prestataire_id . " a été accepté.");
        header("location: ../pdetails.php?id=" . $prestataire_id . "&msg=Prestataire ID " . $prestataire_id . " a bien été accepté !&err=false");
        exit;
    } else {
        logActivity("../", "Prestataire ID " . $prestataire_id . " n'a pas été accepté.");
        header("location: ../prestataires.php?msg=Prestataire ID " . $prestataire_id . " n'a pas été accepté !&err=true");
        exit;
    }
} else {
    logActivity("../", "Une erreur est survenue, ID du prestataire manquant.");
    header("location: ../prestataires.php?msg=Une erreur est survenue, ID du prestataire manquant.&err=true");
    exit;
}
?>
