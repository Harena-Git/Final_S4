CREATE DATABASE tp_flight CHARACTER SET utf8mb4;

USE tp_flight;

-- Tables 
CREATE TABLE client (
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

-- Donnees
-- Client
INSERT INTO client (nom, prenom, email, age) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', 22),
('Martin', 'Claire', 'claire.martin@email.com', 24),
('Nguyen', 'Paul', 'paul.nguyen@email.com', 21);

-- Fonds
INSERT INTO fonds (description, valeur, date_ajout) VALUES
('Fonds principal', 10000.00, '2024-06-01 10:00:00'),
('Fonds secondaire', 5000.00, '2024-06-10 14:30:00'),
('Fonds d urgence', 2000.00, '2024-07-01 09:15:00');

-- Types de prêt
INSERT INTO loan_types (name, interest_rate) VALUES
('Prêt personnel', 3.50),
('Prêt immobilier', 1.80),
('Prêt étudiant', 0.90);

-- Prêts clients
INSERT INTO client_loans (client_id, loan_type_id, fund_id, amount, start_date, end_date, status) VALUES
(1, 1, 1, 2000.00, '2024-07-01', '2025-07-01', 'active'),
(2, 2, 2, 3000.00, '2024-06-15', '2029-06-15', 'active'),
(3, 3, 3, 1500.00, '2024-07-05', NULL, 'active');
