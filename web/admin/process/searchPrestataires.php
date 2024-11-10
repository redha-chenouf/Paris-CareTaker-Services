<?php

include("../include/utils.php");
checkSessionElseLogin("../");

if(isset($_GET['q'])) {
    $searchTerm = $_GET['q'];

    $db = getDatabase();

    $query = "SELECT * FROM utilisateur WHERE (prenom LIKE :searchTerm OR nom LIKE :searchTerm OR email LIKE :searchTerm OR numero_telephone LIKE :searchTerm OR pays_telephone LIKE :searchTerm) AND prestataire IS NOT NULL";
    $stmt = $db->prepare($query);

    $stmt->execute(array(':searchTerm' => '%' . $searchTerm . '%'));

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($results);
} else {
    echo 'Aucun terme de recherche spécifié';
}