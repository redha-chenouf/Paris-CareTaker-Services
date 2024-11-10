<?php
include("../include/utils.php");
checkSessionElseLogin("../");

include("../log.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) && isset($_POST["reason"])) {
        $bailleur_id = htmlspecialchars($_POST["id"]);
        $reason = htmlspecialchars($_POST["reason"]);

        $db = getDatabase();
        $updateBailleur = $db->prepare("UPDATE utilisateur SET bailleur_accept = 0, bailleur_refus = 1, raison_refus = ? WHERE id_utilisateur = ?");
        $updateBailleur->execute([$reason, $bailleur_id]);

        logActivity("../", "Le bailleur id ". $bailleur_id ." a bien été refusé.");
        header("Location: ../bailleurs.php?msg=Le bailleur a bien été refusé.&err=false");
        exit;
    } else {
        logActivity("../", "Erreur lors du refus.");
        header("Location: ../bailleurs.php?msg=Erreur lors du refus.&err=true");
        exit;
    }
} else {
    logActivity("../", "Erreur lors du refus.");
    header("Location: ../bailleurs.php?msg=Erreur lors du refus.&err=true");
    exit;
}
?>
