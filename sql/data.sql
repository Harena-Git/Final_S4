-- Clean existing data
DELETE FROM client_loans;
DELETE FROM loan_types;
DELETE FROM fonds;
DELETE FROM etudiant;

-- Insert sample Client data
INSERT INTO Client (nom, prenom, email, age) VALUES
('Dupont', 'Jean', 'jean.dupont@example.com', 35),
('Martin', 'Claire', 'claire.martin@example.com', 29),
('Durand', 'Paul', 'paul.durand@example.com', 42);

-- Insert sample fonds data
INSERT INTO fonds (description, valeur, date_ajout) VALUES
('Fonds général', 100000.00, NOW()),
('Fonds spécial', 50000.00, NOW());

-- Insert sample loan_types data
INSERT INTO loan_types (name, interest_rate) VALUES
('Prêt personnel', 5.5),
('Prêt immobilier', 3.2),
('Prêt auto', 4.0);

-- Insert sample client_loans data
INSERT INTO client_loans (client_id, loan_type_id, fund_id, amount, start_date, end_date, status) VALUES
(1, 1, 1, 10000.00, '2023-01-15', '2024-01-15', 'active'),
(2, 2, 2, 200000.00, '2023-03-01', '2043-03-01', 'active'),
(3, 3, 1, 15000.00, '2023-05-20', '2028-05-20', 'active');
