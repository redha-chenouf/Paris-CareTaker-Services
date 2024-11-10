<?php

require_once 'config.php';

try {
    // Table utilisateur
    $sql = "CREATE TABLE IF NOT EXISTS utilisateur(
       id_utilisateur INT AUTO_INCREMENT,
       genre TINYINT(1),
       nom VARCHAR(50),
       prenom VARCHAR(50),
       email VARCHAR(100),
       mot_de_passe VARCHAR(70),
       date_inscription DATETIME,
       date_naissance DATE,
       numero_telephone CHAR(10),
       pays_telephone VARCHAR(10),
       bloque DATE,
       supprime DATE,
       accepte DATE,
       code_banque CHAR(5),
       code_guichet CHAR(5),
       numero_de_compte CHAR(11),
       cle_rib CHAR(2),
       iban VARCHAR(34),
       bic VARCHAR(11),
       nom_banque VARCHAR(100),
       url_rib VARCHAR(100),
       administrateur DATE,
       bailleur_accept TINYINT(1) DEFAULT NULL,
       bailleur DATE,
       bailleur_refus TINYINT(1) DEFAULT NULL,
       voyageur DATE,
       prestataire_accept TINYINT(1) DEFAULT NULL,
       prestataire DATE DEFAULT NULL,
       prestataire_refus TINYINT(1) DEFAULT NULL,
       raison_refus TEXT,
       token VARCHAR(512),
       newsletter TINYINT(1) DEFAULT NULL,
       PRIMARY KEY(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table utilisateur créée avec succès<br>";

    // Table bien
    $sql = "CREATE TABLE IF NOT EXISTS bien(
       id_bien INT AUTO_INCREMENT,
       title VARCHAR(100),
       description TEXT,
       address VARCHAR(255),
       city VARCHAR(100),
       code_postal VARCHAR(10),
       prix DECIMAL(10,2),
       type_bien VARCHAR(20),
       nbr_piece INT,
       meuble TINYINT(1),
       duree_location VARCHAR(15),
       nbr_personne_max INT,
       superficie DECIMAL(10,2),
       creation DATETIME,
       maj DATETIME,
       raison_refus TEXT,
       id_bailleur INT NOT NULL,
       id_administrateur INT NOT NULL,
       PRIMARY KEY(id_bien),
       FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_administrateur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table bien créée avec succès<br>";

    // Table occupation
    $sql = "CREATE TABLE IF NOT EXISTS occupation(
       id_occupation INT AUTO_INCREMENT,
       date_debut DATE,
       date_fin DATE,
       raison_indispo TEXT,
       nombre_personne INT,
       id_bien INT NOT NULL,
       id_utilisateur INT NOT NULL,
       PRIMARY KEY(id_occupation),
       FOREIGN KEY(id_bien) REFERENCES bien(id_bien),
       FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table occupation créée avec succès<br>";

    // Table intervention
    $sql = "CREATE TABLE IF NOT EXISTS intervention(
       id_intervention INT AUTO_INCREMENT,
       titre VARCHAR(100),
       description TEXT,
       montant DECIMAL(6,2),
       duree_jour INT,
       id_utilisateur INT NOT NULL,
       PRIMARY KEY(id_intervention),
       FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table intervention créée avec succès<br>";

    // Table etat_des_lieux
    $sql = "CREATE TABLE IF NOT EXISTS etat_des_lieux(
       id_etat INT AUTO_INCREMENT,
       date_etat DATE,
       url VARCHAR(255),
       id_bien INT NOT NULL,
       PRIMARY KEY(id_etat),
       FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
    );";
    $pdo->exec($sql);
    echo "Table etat_des_lieux créée avec succès<br>";

    // Table photo
    $sql = "CREATE TABLE IF NOT EXISTS photo(
       id_photo INT AUTO_INCREMENT,
       url VARCHAR(255),
       id_bien INT NOT NULL,
       PRIMARY KEY(id_photo),
       FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
    );";
    $pdo->exec($sql);
    echo "Table photo créée avec succès<br>";

    // Table prestation
    $sql = "CREATE TABLE IF NOT EXISTS prestation(
       id_prestation INT AUTO_INCREMENT,
       montant DECIMAL(6,2),
       duree_jour INT,
       titre VARCHAR(255),
       description TEXT,
       evolution BOOLEAN,
       id_utilisateur INT NOT NULL,
       PRIMARY KEY(id_prestation),
       FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table prestation créée avec succès<br>";

    // Table paiement
    $sql = "CREATE TABLE IF NOT EXISTS paiement(
       id_paiement INT AUTO_INCREMENT,
       date_paiement DATE,
       paiement_valide BOOLEAN,
       paiement_methode VARCHAR(50),
       montant DECIMAL(15,2),
       raison_rembourssement TEXT,
       id_bien INT NOT NULL,
       PRIMARY KEY(id_paiement),
       FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
    );";
    $pdo->exec($sql);
    echo "Table paiement créée avec succès<br>";

    // Table abonnement
    $sql = "CREATE TABLE IF NOT EXISTS abonnement(
       id_abonnement INT AUTO_INCREMENT,
       type VARCHAR(50),
       description TEXT,
       montant DECIMAL(6,2),
       utilisateur VARCHAR(50),
       PRIMARY KEY(id_abonnement)
    );";
    $pdo->exec($sql);
    echo "Table abonnement créée avec succès<br>";

    // Table habilitation
    $sql = "CREATE TABLE IF NOT EXISTS habilitation(
       id_habilitation INT AUTO_INCREMENT,
       nom VARCHAR(50),
       description TEXT,
       url VARCHAR(255),
       id_bailleur INT NOT NULL,
       id_administrateur INT NOT NULL,
       PRIMARY KEY(id_habilitation),
       FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_administrateur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table habilitation créée avec succès<br>";

    // Table message
    $sql = "CREATE TABLE IF NOT EXISTS message(
       id_message INT AUTO_INCREMENT,
       message TEXT,
       id_bailleur INT NOT NULL,
       id_voyageur INT NOT NULL,
       PRIMARY KEY(id_message),
       FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_voyageur) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table message créée avec succès<br>";

    // Table facture
    $sql = "CREATE TABLE IF NOT EXISTS facture(
       id_facture INT AUTO_INCREMENT,
       url VARCHAR(255),
       date_creation DATETIME,
       service VARCHAR(100),
       description TEXT,
       id_paiement INT NOT NULL,
       PRIMARY KEY(id_facture),
       FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement)
    );";
    $pdo->exec($sql);
    echo "Table facture créée avec succès<br>";

    // Table intervenu_pour
    $sql = "CREATE TABLE IF NOT EXISTS intervenu_pour(
       id_bien INT,
       id_intervention INT,
       id_paiement INT,
       date_debut_intervention DATETIME,
       date_fin_intervention DATETIME,
       description TEXT,
       prix DECIMAL(6,2),
       url_fiche_intervention VARCHAR(255),
       PRIMARY KEY(id_bien, id_intervention, id_paiement),
       FOREIGN KEY(id_bien) REFERENCES bien(id_bien),
       FOREIGN KEY(id_intervention) REFERENCES intervention(id_intervention),
       FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement)
    );";
    $pdo->exec($sql);
    echo "Table intervenu_pour créée avec succès<br>";

    // Table prestation_commande
    $sql = "CREATE TABLE IF NOT EXISTS prestation_commande(
       id_utilisateur INT,
       id_utilisateur_1 INT,
       id_prestation INT,
       id_paiement INT,
       montant DECIMAL(6,2),
       evaluation INT,
       url_fiche VARCHAR(255),
       debut_prestation DATE,
       duree INT,
       fin_prestation DATE,
       status VARCHAR(50),
       PRIMARY KEY(id_utilisateur, id_utilisateur_1, id_prestation, id_paiement),
       FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_utilisateur_1) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_prestation) REFERENCES prestation(id_prestation),
       FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement)
    );";
    $pdo->exec($sql);
    echo "Table prestation_commande créée avec succès<br>";

    // Table abonnement_commande
    $sql = "CREATE TABLE IF NOT EXISTS abonnement_commande(
       id_utilisateur INT,
       id_paiement INT,
       id_abonnement INT,
       montant DECIMAL(6,2),
       date_debut DATE,
       date_fin DATE,
       PRIMARY KEY(id_utilisateur, id_paiement, id_abonnement),
       FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
       FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement),
       FOREIGN KEY(id_abonnement) REFERENCES abonnement(id_abonnement)
    );";
    $pdo->exec($sql);
    echo "Table abonnement_commande créée avec succès<br>";

    // Table refresh_tokens
    $sql = "CREATE TABLE IF NOT EXISTS refresh_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        refresh_token VARCHAR(512) NOT NULL,
        expiry_date DATETIME NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES utilisateur(id_utilisateur)
    );";
    $pdo->exec($sql);
    echo "Table refresh_tokens créée avec succès<br>";

    echo "Toutes les tables ont été créées avec succès";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

?>
