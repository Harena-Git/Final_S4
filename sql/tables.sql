CREATE DATABASE tp_flight CHARACTER SET utf8mb4;

USE tp_flight;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    age INT
);

CREATE TABLE Profil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom ENUM('admin', 'client') NOT NULL
);

CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_profil INT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    contact VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    solde DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (id_profil) REFERENCES Profil(id)
);

CREATE TABLE ComptePret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_profil INT,
    solde DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_profil) REFERENCES Profil(id)
);

CREATE TABLE TypePret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    taux DECIMAL(5, 2) NOT NULL,
    duree int 
);

CREATE TABLE Pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_type_pret INT,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id),
    FOREIGN KEY (id_type_pret) REFERENCES TypePret(id)
);

CREATE TABLE Remboursement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_pret_client INT,
    date_remboursement DATE NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_client) REFERENCES Utilisateur(id),
    FOREIGN KEY (id_pret_client) REFERENCES Pret(id)
);

CREATE TABLE Fond (
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10, 2) NOT NULL
);
