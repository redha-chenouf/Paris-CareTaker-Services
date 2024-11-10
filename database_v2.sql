CREATE TABLE utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   genre ENUM('homme', 'femme','autre') DEFAULT NULL,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   email VARCHAR(100),
   mot_de_passe VARCHAR(70),
   date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
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
   bailleur_accept tinyint(1) DEFAULT NULL,
   bailleur DATE,
   bailleur_refus tinyint(1) DEFAULT NULL,
   voyageur DATE,
   prestataire_accept tinyint(1) DEFAULT NULL,
   prestataire date DEFAULT NULL,
   prestataire_refus tinyint(1) DEFAULT NULL,
   raison_refus TEXT,
   token VARCHAR(512),
   newsletter tinyint(1),
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE bien(
   id_bien INT AUTO_INCREMENT,
   title VARCHAR(100),
   description TEXT,
   address VARCHAR(255),
   city VARCHAR(100),
   code_postal VARCHAR(10),
   type_bien VARCHAR(20),
   prix DECIMAL(10,2),
   meuble TINYINT(1),
   duree_location VARCHAR(15), /*courte periode ou longue periode*/
   salon INT,
   cuisine INT,
   salle_de_bain INT,
   toilette INT,
   chambre INT
   nbr_personne_max INT,
   superficie DECIMAL(10,2),
   creation DATETIME DEFAULT CURRENT_TIMESTAMP,
   maj DATETIME,
   refus_bot tinyint(1),
   raison_refus TEXT,
   id_bailleur INT NOT NULL,
   id_administrateur INT NOT NULL,
   PRIMARY KEY(id_bien),
   FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_administrateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE occupation(
   id_occupation INT AUTO_INCREMENT,
   date_debut DATE,
   date_fin DATE,
   raison_indispo TEXT,
   nombre_personne INT,
   status ENUM('available', 'blocked') DEFAULT 'available',
   id_bien INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_occupation),
   FOREIGN KEY(id_bien) REFERENCES bien(id_bien),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);



CREATE TABLE etat_des_lieux(
   id_etat INT AUTO_INCREMENT,
   date_etat DATE,
   url VARCHAR(255),
   id_bien INT NOT NULL,
   PRIMARY KEY(id_etat),
   FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
);

CREATE TABLE photo(
   id_photo INT AUTO_INCREMENT,
   url VARCHAR(255),
   id_bien INT NOT NULL,
   PRIMARY KEY(id_photo),
   FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
);

CREATE TABLE prestation(
   id_prestation INT AUTO_INCREMENT,
   montant DECIMAL(6,2),
   duree_jour INT,
   titre VARCHAR(255),
   description TEXT,
   evolution BOOLEAN,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_prestation),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE paiement(
   id_paiement INT AUTO_INCREMENT,
   date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
   paiement_valide BOOLEAN,
   paiement_methode VARCHAR(50),
   montant DECIMAL(15,2),
   raison_remboursement TEXT,
   id_bien INT NOT NULL,
   PRIMARY KEY(id_paiement),
   FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
);

CREATE TABLE abonnement(
   id_abonnement INT AUTO_INCREMENT,
   type VARCHAR(50),
   description TEXT,
   montant DECIMAL(6,2),
   utilisateur VARCHAR(50),
   PRIMARY KEY(id_abonnement)
);

CREATE TABLE habilitation(
   id_habilitation INT AUTO_INCREMENT,
   nom VARCHAR(50),
   description TEXT,
   url VARCHAR(255),
   id_bailleur INT NOT NULL,
   id_administrateur INT NOT NULL,
   PRIMARY KEY(id_habilitation),
   FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_administrateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE message(
   id_message INT AUTO_INCREMENT,
   message TEXT,
   id_bailleur INT NOT NULL,
   id_voyageur INT NOT NULL,
   PRIMARY KEY(id_message),
   FOREIGN KEY(id_bailleur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_voyageur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE facture(
   id_facture INT AUTO_INCREMENT,
   url VARCHAR(255),
   date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
   service VARCHAR(100),
   description TEXT,
   id_paiement INT NOT NULL,
   PRIMARY KEY(id_facture),
   FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement)
);

CREATE TABLE prestation_commande(
   id_utilisateur INT,
   id_prestataire INT,
   id_bien INT,
   id_prestation INT,
   id_paiement INT,
   montant DECIMAL(6,2),
   evaluation BYTE,
   url_fiche VARCHAR(255),
   debut_prestation DATE,
   duree SMALLINT,
   fin_prestation DATE,
   status VARCHAR(50),
   fiche_url VARCHAR(255),
   PRIMARY KEY(id_utilisateur, id_prestataire, id_bien, id_prestation, id_paiement),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_prestataire) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_bien) REFERENCES bien(id_bien),
   FOREIGN KEY(id_prestation) REFERENCES prestation(id_prestation),
   FOREIGN KEY(id_paiement) REFERENCES paiement(id_paiement)
);


CREATE TABLE abonnement_commande(
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
);


CREATE TABLE nfc_log(
   id_log INT AUTO_INCREMENT,
   nfc_id VARCHAR(100),
   log_date_time DATETIME,
   id_bien INT NOT NULL,
   PRIMARY KEY(id_log)
);
database.sql
7 Ko