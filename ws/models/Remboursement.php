<?php
require_once __DIR__ . '/../db.php';

class Remboursement {
    public static function create($client_loan_id, $montant, $date_prevue, $date_effectue, $statut, $numero_echeance, $delai_premier_remboursement, $montant_interet, $montant_principal, $solde_restant) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO remboursement (client_loan_id, montant, date_prevue, date_effectue, statut, numero_echeance, delai_premier_remboursement, montant_interet, montant_principal, solde_restant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$client_loan_id, $montant, $date_prevue, $date_effectue, $statut, $numero_echeance, $delai_premier_remboursement, $montant_interet, $montant_principal, $solde_restant]);
        return $db->lastInsertId();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM remboursement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByLoan($client_loan_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM remboursement WHERE client_loan_id = ? ORDER BY numero_echeance");
        $stmt->execute([$client_loan_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        $db = getDB();
        $fields = [];
        $values = [];

        if (isset($data->montant) && is_numeric($data->montant)) {
            $fields[] = 'montant = ?';
            $values[] = floatval($data->montant);
        }
        if (isset($data->date_prevue) {
            $fields[] = 'date_prevue = ?';
            $values[] = $data->date_prevue;
        }
        if (isset($data->date_effectue)) {
            $fields[] = 'date_effectue = ?';
            $values[] = $data->date_effectue;
        }
        if (isset($data->statut)) {
            $fields[] = 'statut = ?';
            $values[] = $data->statut;
        }
        if (isset($data->montant_interet) && is_numeric($data->montant_interet)) {
            $fields[] = 'montant_interet = ?';
            $values[] = floatval($data->montant_interet);
        }
        if (isset($data->montant_principal) && is_numeric($data->montant_principal)) {
            $fields[] = 'montant_principal = ?';
            $values[] = floatval($data->montant_principal);
        }
        if (isset($data->solde_restant) && is_numeric($data->solde_restant)) {
            $fields[] = 'solde_restant = ?';
            $values[] = floatval($data->solde_restant);
        }

        if (empty($fields)) {
            throw new Exception('Aucun champ valide à mettre à jour');
        }

        $values[] = intval($id);

        $stmt = $db->prepare("UPDATE remboursement SET " . implode(', ', $fields) . " WHERE id = ?");
        $stmt->execute($values);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM remboursement WHERE id = ?");
        $stmt->execute([intval($id)]);
    }
}