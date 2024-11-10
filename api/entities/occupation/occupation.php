<?php

require __DIR__ . '/../../database/config.php';


// function createOccupation($data) {
//     global $pdo;
//     $sql = "INSERT INTO occupation (date_debut, date_fin, raison_indispo, nombre_personne, id_bien, id_utilisateur)
//             VALUES (:date_debut, :date_fin, :raison_indispo, :nombre_personne, :id_bien, :id_utilisateur)";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function getOccupation($id) {
    global $pdo;
    $sql = "SELECT * FROM occupation WHERE id_occupation = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllOccupations() {
    global $pdo;
    $sql = "SELECT * FROM occupation";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// function updateOccupation($id, $data) {
//     global $pdo;
//     $data['id'] = $id;
//     $sql = "UPDATE occupation SET date_debut = :date_debut, date_fin = :date_fin, raison_indispo = :raison_indispo, nombre_personne = :nombre_personne, id_bien = :id_bien, id_utilisateur = :id_utilisateur WHERE id_occupation = :id";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function deleteOccupation($id) {
    global $pdo;
    $sql = "DELETE FROM occupation WHERE id_occupation = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}



function checkAvailability($id_bien, $start_date, $end_date) {
    global $pdo;
    // Vérifier si une occupation existe pour les dates sélectionnées
    $sql = "SELECT COUNT(*) AS count FROM occupation WHERE id_bien = :id_bien AND ((date_debut <= :start_date AND date_fin >= :start_date) OR (date_debut <= :end_date AND date_fin >= :end_date))";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_bien' => $id_bien, 'start_date' => $start_date, 'end_date' => $end_date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] == 0; // Si le compte est 0, les dates sont disponibles
}

function makeReservation($id_bien, $start_date, $end_date, $id_utilisateur) {
    global $pdo;
    // Insérer une nouvelle entrée dans la table occupation pour la réservation
    $sql = "INSERT INTO occupation (date_debut, date_fin, id_bien, id_utilisateur) VALUES (:start_date, :end_date, :id_bien, :id_utilisateur)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date, 'id_bien' => $id_bien, 'id_utilisateur' => $id_utilisateur]);
}


function createOccupation($data) {
    global $pdo;

    $sql = "INSERT INTO occupation (date_debut, date_fin, raison_indispo, nombre_personne, id_bien, id_utilisateur) 
            VALUES (:date_debut, :date_fin, :raison_indispo, :nombre_personne, :id_bien, :id_utilisateur)";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

function updateOccupation($id, $data) {
    global $pdo;

    $data['id'] = $id;
    $sql = "UPDATE occupation SET date_debut = :date_debut, date_fin = :date_fin, raison_indispo = :raison_indispo, nombre_personne = :nombre_personne, id_bien = :id_bien, id_utilisateur = :id_utilisateur WHERE id_occupation = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

?>