-- Insert into Profil (admin, client)
INSERT INTO Profil (nom) VALUES
('admin'),
('client');

-- Insert into Utilisateur (admin and client)
INSERT INTO Utilisateur (id_profil, nom, prenom, date_naissance, contact, mot_de_passe, solde) VALUES
(1, 'Dupont', 'Jean', '1985-07-12', '0123456789', 'adminpassword', 1000.00),  -- Admin user
(2, 'Durand', 'Marie', '1990-11-24', '0987654321', 'clientpassword', 500.00); -- Client user

-- Insert into ComptePret (with sample solde)
INSERT INTO ComptePret (id_profil, solde) VALUES
(1, 1500.00), -- Admin account
(2, 200.00);  -- Client account

-- Insert into TypePret
INSERT INTO TypePret (nom, taux,duree) VALUES
('Prêt personnel', 5.00,30),
('Prêt immobilier', 3.50,90),
('Prêt étudiant', 4.00,150);

-- Insert into Pret (sample loans for users)
INSERT INTO Pret (id_utilisateur, id_type_pret, date_debut, date_fin, montant) VALUES
(2, 1, '2025-01-01', '2025-12-31', 1000.00),  -- Client loan
(2, 2, '2025-06-01', '2035-06-01', 20000.00); -- Client mortgage loan

-- Insert into Remboursement (payments made by client)
INSERT INTO Remboursement (id_client, id_pret_client, date_remboursement, montant) VALUES
(2, 1, '2025-02-15', 100.00),
(2, 1, '2025-03-15', 150.00);

-- Insert into Fond (funds available for loans)
INSERT INTO Fond (montant) VALUES
(50000.00);  -- Total available funds
