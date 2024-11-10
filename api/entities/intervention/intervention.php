<?php

require __DIR__ . '/../../database/config.php';


// function createIntervention($data) {
//     global $pdo;
//     $sql = "INSERT INTO intervention (date_debut_intervention, date_fin_intervention, raison, description, id_utilisateur) VALUES (:date_debut_intervention, :date_fin_intervention, :raison, :description, :id_utilisateur)";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function getIntervention($id) {
    global $pdo;
    $sql = "SELECT * FROM intervention WHERE id_intervention = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllInterventions() {
    global $pdo;
    $sql = "SELECT * FROM intervention";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// function updateIntervention($id, $data) {
//     global $pdo;
//     $data['id'] = $id;
//     $sql = "UPDATE intervention SET date_debut_intervention = :date_debut_intervention, date_fin_intervention = :date_fin_intervention, raison = :raison, description = :description WHERE id_intervention = :id";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function deleteIntervention($id) {
    global $pdo;
    $sql = "DELETE FROM intervention WHERE id_intervention = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

function createIntervention($data) {
    global $pdo;

    $sql = "INSERT INTO intervention (titre, description, montant, duree_jour, id_utilisateur) 
            VALUES (:titre, :description, :montant, :duree_jour, :id_utilisateur)";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function updateIntervention($id, $data) {
    global $pdo;

    $data['id'] = $id;
    $sql = "UPDATE intervention SET titre = :titre, description = :description, montant = :montant, duree_jour = :duree_jour, id_utilisateur = :id_utilisateur WHERE id_intervention = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

?>
