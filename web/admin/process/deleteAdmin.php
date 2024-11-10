<?php

include("../include/utils.php");
checkSessionElseLogin("../");

include("../log.php");

$db = getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["username"]) && !empty($_POST["username"])) {

        $id = $_POST["userId"];
        $username = $_POST["username"];
        
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = :id AND administrateur IS NOT NULL";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if (!$existingUser) {
            logActivity("../", "Erreur lors de la suppression d'un administrateur, il n'existe pas.");
            header("location: ../administrateur.php?msg=Erreur lors de la suppression d'un administrateur, il n'existe pas.&err=true");
            exit();
        }

        $query = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            logActivity("../", "L'administrateur ". $username ." a été supprimé.");
            header("location: ../administrateur.php?msg=L'administrateur ". $username ." à bien été supprimé.&err=false");
            exit();
        } else {
            logActivity("../", "L'administrateur ". $username ." n'a pas pu être supprimé.");
            header("location: ../administrateur.php?msg=L'administrateur ". $username ." n'a pas pu être supprimé.&err=true");
            exit();
        }

    }
}