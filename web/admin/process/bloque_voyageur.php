<?php
include("../include/utils.php");
checkSessionElseLogin("");

include("../log.php");

if(isset($_POST["id"])) {
    $voyageur_id = htmlspecialchars($_POST["id"]);

    if(isset($_POST["reason"]) && !empty($_POST["reason"])) {
        $reason = htmlspecialchars($_POST["reason"]);
    } else {
        logActivity("../", "Annulation blocage car raison non renseignée pour l'id " . $voyageur_id);
        header("Location: ../vdetails.php?id=". $voyageur_id ."&msg=Raison non renseignée&err=true");
        exit;
    }

    $db = getDatabase();

    $updateVoyageur = $db->prepare("UPDATE utilisateur SET bloque = ?, raison_refus = ? WHERE id_utilisateur = ?");
    $updateVoyageur->execute([date("Y-m-d"), $reason, $voyageur_id]);

    logActivity("../", "Le voyageur " . $voyageur_id . " a été bloqué avec succés");
    header("Location: ../vdetails.php?id=". $voyageur_id ."&msg=Le voyageur a été bloqué avec succès.&err=false");
    exit;
} else {
    logActivity("../", "Erreur le voyageur n'a pas été bloqué avec succès.");
    header("Location: ../voyageurs.php?msg=Le voyageur n'a pas été bloqué avec succès.&err=true");
    exit;
}
?>
