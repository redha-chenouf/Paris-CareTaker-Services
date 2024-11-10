<?php
include("../include/utils.php");
checkSessionElseLogin("../");


include("../log.php");
logActivity("../", "page refuse bailleur de " . $_POST["id"]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $bailleur_id = htmlspecialchars($_POST["id"]);

    $db = getDatabase();

    $getBailleur = $db->prepare("UPDATE utilisateur SET bailleur_accept = 1, bailleur_refus = 0 WHERE id_utilisateur = ?");
    $getBailleur->execute([$bailleur_id]);
    $rowsAffected = $getBailleur->rowCount();

    if ($rowsAffected > 0) {
        logActivity("../", "Bailleur id ". $bailleur_id ." a été accepté.");
        header("location: ../bdetails.php?id=". $bailleur_id ."&msg=Bailleur id ". $bailleur_id ." a bien été accepté !&err=false");
    } else {
        logActivity("../", "Bailleur id ". $bailleur_id ." n'a pas été accepté.");
        header("location: ../bailleurs.php?msg=Bailleur id ". $bailleur_id ." n'a pas été accepté !&err=true");
    }

} else {
    logActivity("../", "Une erreur est survenue, traitement annulé.");
    header("location: ../bailleurs.php?msg=Une erreur est survenue, traitement annulé.&err=true");
}