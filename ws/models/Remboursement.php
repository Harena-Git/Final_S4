<?php
require_once __DIR__ . '/../db.php';

class Remboursement {
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO remboursement 
                             (client_loan_id, montant, date_prevue, date_effectue, statut, 
                              numero_echeance, delai_premier_remboursement, 
                              montant_interet, montant_principal, solde_restant) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['client_loan_id'],
                $data['montant'],
                $data['date_prevue'],
                $data['date_effectue'],
                $data['statut'],
                $data['numero_echeance'],
                $data['delai_premier_remboursement'],
                $data['montant_interet'],
                $data['montant_principal'],
                $data['solde_restant']
            ]);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur lors de la création du remboursement: " . $e->getMessage());
            return false;
        }
    }

    public static function getByLoanId($loanId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM remboursement WHERE client_loan_id = ? ORDER BY numero_echeance");
        $stmt->execute([$loanId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}