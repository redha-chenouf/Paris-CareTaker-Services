<?php

require __DIR__ . '/../../database/config.php';


// function createPrestation($data) {
//     global $pdo;
//     $sql = "INSERT INTO prestation (montant, duree_jour, titre, description, evolution, id_utilisateur)
//             VALUES (:montant, :duree_jour, :titre, :description, :evolution, :id_utilisateur)";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function getPrestation($id) {
    global $pdo;
    $sql = "SELECT * FROM prestation WHERE id_prestation = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getAllPrestations() {
    global $pdo;
    $sql = "SELECT * FROM prestation";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// function updatePrestation($id, $data) {
//     global $pdo;
//     $data['id'] = $id;
//     $sql = "UPDATE prestation SET montant = :montant, duree_jour = :duree_jour, titre = :titre, description = :description, evolution = :evolution, id_utilisateur = :id_utilisateur WHERE id_prestation = :id";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function deletePrestation($id) {
    global $pdo;
    $sql = "DELETE FROM prestation WHERE id_prestation = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}


function createPrestation($data) {
    global $pdo;

    $sql = "INSERT INTO prestation (montant, duree_jour, titre, description, evolution, id_utilisateur) 
            VALUES (:montant, :duree_jour, :titre, :description, :evolution, :id_utilisateur)";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function updatePrestation($id, $data) {
    global $pdo;

    $data['id'] = $id;
    $sql = "UPDATE prestation SET montant = :montant, duree_jour = :duree_jour, titre = :titre, description = :description, evolution = :evolution, id_utilisateur = :id_utilisateur WHERE id_prestation = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

?>



