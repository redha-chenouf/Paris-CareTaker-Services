<?php
include("../include/utils.php");
checkSessionElseLogin("");

include("../log.php");

$db = getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["userId"]) && !empty($_POST["userId"]) &&
        isset($_POST["editUsername"]) && !empty($_POST["editUsername"]) &&
        isset($_POST["editPrenom"]) && !empty($_POST["editPrenom"]) &&
        isset($_POST["editEmail"]) && !empty($_POST["editEmail"])
    ) {
        $id = $_POST["userId"];
        $username = $_POST["editUsername"];
        $prenom = $_POST["editPrenom"];
        $email = $_POST["editEmail"];
        $password = $_POST["editPassword"];

        $query = "SELECT COUNT(*) FROM utilisateur WHERE email = :email AND id_utilisateur != :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            logActivity("../", "Erreur lors de la modification de l'administrateur $username. L'adresse mail existe déjà pour un autre administrateur.");
            header("location: ../administrateur.php?msg=L'adresse e-mail existe déjà pour un autre administrateur.&err=true");
            exit();
        }

        $query = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email";
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query .= ", mot_de_passe = :password";
        }
        $query .= " WHERE id_utilisateur = :id";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(":nom", $username);
        $stmt->bindParam(":prenom", $prenom); // Corrected here from $username to $prenom
        $stmt->bindParam(":email", $email);
        
        if (!empty($password)) {
            $stmt->bindParam(":password", $hashedPassword);
        }

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            logActivity("../", "L'administrateur $username a été modifié.");
            header("location: ../administrateur.php?msg=L'administrateur $username a été modifié avec succès.&err=false");
            exit();
        } else {
            logActivity("../", "Erreur lors de la modification de l'administrateur $username.");
            header("location: ../administrateur.php?msg=Erreur lors de la modification de l'administrateur $username.&err=true");
            exit();
        }
    }
}
?>
