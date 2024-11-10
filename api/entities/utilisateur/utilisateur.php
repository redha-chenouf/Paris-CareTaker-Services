<?php

require __DIR__ . '/../../database/config.php';



function createUtilisateur($data) {
    global $pdo;

    // Vérifiez que toutes les clés nécessaires sont présentes
    $required_keys = [
        'nom', 'prenom', 'email', 'mot_de_passe', 'date_inscription', 'date_naissance',
        'numero_telephone', 'pays_telephone', 'bloque', 'supprime', 'accepte', 'code_banque',
        'code_guichet', 'numero_de_compte', 'cle_rib', 'iban', 'bic', 'nom_banque', 'url_rib',
        'administrateur', 'bailleur_accept', 'bailleur', 'bailleur_refus', 'voyageur', 
        'prestataire_accept', 'prestataire', 'prestataire_refus', 'raison_refus', 'newsletter'
    ];

    // Initialisation des valeurs par défaut pour les clés manquantes
    foreach ($required_keys as $key) {
        if (!array_key_exists($key, $data)) {
            $data[$key] = null; // ou une autre valeur par défaut appropriée
        }
    }

    $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, date_inscription, date_naissance, 
            numero_telephone, pays_telephone, bloque, supprime, accepte, code_banque, code_guichet, 
            numero_de_compte, cle_rib, iban, bic, nom_banque, url_rib, administrateur, bailleur_accept, 
            bailleur, bailleur_refus, voyageur, prestataire_accept, prestataire, prestataire_refus, raison_refus, token)
            VALUES (:nom, :prenom, :email, :mot_de_passe, :date_inscription, :date_naissance, 
            :numero_telephone, :pays_telephone, :bloque, :supprime, :accepte, :code_banque, :code_guichet, 
            :numero_de_compte, :cle_rib, :iban, :bic, :nom_banque, :url_rib, :administrateur, :bailleur_accept, 
            :bailleur, :bailleur_refus, :voyageur, :prestataire_accept, :prestataire, :prestataire_refus, :raison_refus, :newsletter)";

    $stmt = $pdo->prepare($sql);

    // Exécution de la requête avec les données
    $result = $stmt->execute($data);

    // Vérifiez si l'exécution a réussi
    if ($result) {
        http_response_code(200); // OK
    } else {
        http_response_code(500); // Internal Server Error
    }

    return $result;
}



function getUtilisateur($id) {
    global $pdo;
    $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUtilisateurs() {
    global $pdo;
    $sql = "SELECT * FROM utilisateur";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function updateUtilisateur($id, $data) {
    global $pdo;
    $data['id'] = $id;

    $required_keys = [
        'nom', 'prenom', 'email', 'mot_de_passe', 'date_inscription', 'date_naissance',
        'numero_telephone', 'pays_telephone', 'bloque', 'supprime', 'accepte', 'code_banque',
        'code_guichet', 'numero_de_compte', 'cle_rib', 'iban', 'bic', 'nom_banque', 'url_rib',
        'administrateur', 'bailleur_accept', 'bailleur', 'bailleur_refus', 'voyageur', 
        'prestataire_accept', 'prestataire', 'prestataire_refus', 'raison_refus', 'newsletter'
    ];

    foreach ($required_keys as $key) {
        if (!array_key_exists($key, $data)) {
            $data[$key] = null;
        }
    }

    $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, date_inscription = :date_inscription, date_naissance = :date_naissance, numero_telephone = :numero_telephone, pays_telephone = :pays_telephone, bloque = :bloque, supprime = :supprime, accepte = :accepte, code_banque = :code_banque, code_guichet = :code_guichet, numero_de_compte = :numero_de_compte, cle_rib = :cle_rib, iban = :iban, bic = :bic, nom_banque = :nom_banque, url_rib = :url_rib, administrateur = :administrateur, bailleur_accept = :bailleur_accept, bailleur = :bailleur, bailleur_refus = :bailleur_refus, voyageur = :voyageur, prestataire_accept = :prestataire_accept, prestataire = :prestataire, prestataire_refus = :prestataire_refus, raison_refus = :raison_refus, newsletter = :newsletter WHERE id_utilisateur = :id";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}


function deleteUtilisateur($id) {
    global $pdo;
    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}
?>
