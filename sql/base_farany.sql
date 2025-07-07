CREATE DATABASE tp_flight CHARACTER SET utf8mb4;
USE tp_flight;

CREATE TABLE etablissement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    fond DECIMAL(12,2) DEFAULT 0.00,
    date_creation DATE DEFAULT CURRENT_DATE
);

CREATE TABLE type_pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    taux DECIMAL(5,2) NOT NULL CHECK (taux > 0),
    duree_max INT NOT NULL CHECK (duree_max > 0),
    montant_min DECIMAL(12,2) NOT NULL CHECK (montant_min >= 0),
    montant_max DECIMAL(12,2) CHECK (montant_max >= 0)
);

CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    cin VARCHAR(20) UNIQUE NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    date_inscription DATE DEFAULT CURRENT_DATE
);

CREATE TABLE pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_type_pret INT NOT NULL,
    montant DECIMAL(12,2) NOT NULL CHECK (montant > 0),
    duree INT NOT NULL CHECK (duree > 0),
    date_pret DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_client) REFERENCES client(id),
    FOREIGN KEY (id_type_pret) REFERENCES type_pret(id)
);

CREATE TABLE remboursement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pret INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_prevue DATE NOT NULL,
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE TABLE historique_fond (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etablissement INT NOT NULL,
    type_operation ENUM('ajout', 'retrait') ,
    montant DECIMAL(12,2) NOT NULL CHECK (montant > 0),
    commentaire TEXT,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etablissement) REFERENCES etablissement(id)
);
CREATE TABLE statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);
ALTER TABLE pret
    ADD COLUMN id_statut INT DEFAULT NULL,
    ADD FOREIGN KEY (id_statut) REFERENCES statut(id);

CREATE TABLE historique_statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pret INT NOT NULL,
    id_statut INT NOT NULL,
    date_changement DATETIME DEFAULT CURRENT_TIMESTAMP,
    commentaire TEXT,
    FOREIGN KEY (id_pret) REFERENCES pret(id),
    FOREIGN KEY (id_statut) REFERENCES statut(id)
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'gestionnaire') DEFAULT 'gestionnaire',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    dernier_acces DATETIME,
    actif BOOLEAN DEFAULT TRUE
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'gestionnaire', 'admin') NOT NULL DEFAULT 'client',
    id_client INT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME NULL,
    FOREIGN KEY (id_client) REFERENCES client(id) ON DELETE CASCADE
);/**/

INSERT INTO statut (libelle, description) VALUES
('en_attente', 'Le prêt est en attente de validation'),
('approuve', 'Le prêt a été approuvé'),
('refuse', 'Le prêt a été refusé'),
('en_cours', 'Le prêt est en cours de remboursement'),
('rembourse', 'Le prêt a été entièrement remboursé');