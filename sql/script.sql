CREATE DATABASE tp_flight CHARACTER SET utf8mb4;

USE tp_flight;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    age INT
);

CREATE TABLE fonds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(50),
    valeur DECIMAL(10,2) NOT NULL,
    date_ajout DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS loan_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    interest_rate DECIMAL(5,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS client_loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    loan_type_id INT NOT NULL,
    fund_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    status VARCHAR(50) DEFAULT 'active',
    FOREIGN KEY (fund_id) REFERENCES fonds(id)
);

CREATE TABLE IF NOT EXISTS remboursement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_loan_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_remboursement DATE NOT NULL,
    mode_paiement VARCHAR(50) DEFAULT 'espèces',
    remarque TEXT,
    FOREIGN KEY (client_loan_id) REFERENCES client_loans(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
