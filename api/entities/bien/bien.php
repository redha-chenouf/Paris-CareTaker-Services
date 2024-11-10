<?php

require __DIR__ . '/../../database/config.php';


// function createBien($data) {
//     global $pdo;
//     $sql = "INSERT INTO bien (title, description, address, city, code_postal, pays, prix, salon, cuisine, salle_de_bain, toilette, chambre, superficie, creation, maj, raison_refus, id_utilisateur, id_utilisateur_1)
//             VALUES (:title, :description, :address, :city, :code_postal, :pays, :prix, :salon, :cuisine, :salle_de_bain, :toilette, :chambre, :superficie, :creation, :maj, :raison_refus, :id_utilisateur, :id_utilisateur_1)";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function getBien($id) {
    global $pdo;
    $sql = "SELECT * FROM bien WHERE id_bien = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getOccupationsByBien($id_bien) {
    global $pdo;
    $sql = "SELECT date_debut, date_fin, raison_indispo FROM occupation WHERE id_bien = :id_bien";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_bien' => $id_bien]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getAllBiens() {
    global $pdo;
    $sql = "SELECT * FROM bien";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// function updateBien($id, $data) {
//     global $pdo;
//     $data['id'] = $id;
//     $sql = "UPDATE bien SET title = :title, description = :description, address = :address, city = :city, code_postal = :code_postal, pays = :pays, prix = :prix, salon = :salon, cuisine = :cuisine, salle_de_bain = :salle_de_bain, toilette = :toilette, chambre = :chambre, superficie = :superficie, creation = :creation, maj = :maj, raison_refus = :raison_refus, id_utilisateur = :id_utilisateur, id_utilisateur_1 = :id_utilisateur_1 WHERE id_bien = :id";
//     $stmt = $pdo->prepare($sql);
//     return $stmt->execute($data);
// }


function deleteBien($id) {
    global $pdo;
    $sql = "DELETE FROM bien WHERE id_bien = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}



function createBien($data) {
    global $pdo;

    // Vérifiez que toutes les clés nécessaires sont présentes
    $required_keys = [
        'title', 'description', 'address', 'city', 'code_postal', 'prix', 
        'type_bien', 'nbr_pieces', 'meuble', 'duree_location', 'nbr_personne_max', 
        'superficie', 'creation', 'maj', 'raison_refus', 'id_bailleur', 'id_administrateur'
    ];

    // Initialisation des valeurs par défaut pour les clés manquantes
    foreach ($required_keys as $key) {
        if (!array_key_exists($key, $data)) {
            $data[$key] = null; // ou une autre valeur par défaut appropriée
        }
    }

    $sql = "INSERT INTO bien (title, description, address, city, code_postal, prix, type_bien, nbr_pieces, meuble, duree_location, nbr_personne_max, superficie, creation, maj, raison_refus, id_bailleur, id_administrateur) 
            VALUES (:title, :description, :address, :city, :code_postal, :prix, :type_bien, :nbr_pieces, :meuble, :duree_location, :nbr_personne_max, :superficie, :creation, :maj, :raison_refus, :id_bailleur, :id_administrateur)";

    $stmt = $pdo->prepare($sql);

    // Exécution de la requête avec les données
    $result = $stmt->execute($data);

    // Vérifiez si l'exécution a réussi
    if ($result) {
        http_response_code(200); // OK
        echo json_encode(['message' => 'Bien created successfully']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Error creating bien']);
    }

    return $result;
}

function updateBien($id, $data) {
    global $pdo;

    $data['id'] = $id;
    $sql = "UPDATE bien SET title = :title, description = :description, address = :address, city = :city, code_postal = :code_postal, pays = :pays, prix = :prix, type_bien = :type_bien, nbr_pieces = :nbr_pieces, meuble = :meuble, duree_location = :duree_location, nbr_personne_max = :nbr_personne_max, superficie = :superficie, creation = :creation, maj = :maj, raison_refus = :raison_refus, id_bailleur = :id_bailleur, id_administrateur = :id_administrateur WHERE id_bien = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['bien_id'])) {
    $id_bien = $_GET['bien_id'];
    $occupations = getOccupationsByBien($id_bien);
    echo json_encode($occupations);
    exit;
}
?>