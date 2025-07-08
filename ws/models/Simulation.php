<?php
require_once __DIR__ . '/../db.php';

class Simulation {
    public static function create($client_id, $loan_type_id, $amount, $duration_months) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO loan_simulations (client_id, loan_type_id, amount, duration_months) VALUES (?, ?, ?, ?)");
        $stmt->execute([$client_id, $loan_type_id, $amount, $duration_months]);
        return $db->lastInsertId();
    }

    // ✅ Nouvelle méthode : Enregistrer dans la table `pret`
    public static function saveToPret($simulationId, $fundId) {
        $db = getDB();

        // Vérifie que la simulation est approuvée
        $stmt = $db->prepare("SELECT * FROM loan_simulations WHERE id = ? AND validation_status = 'approved'");
        $stmt->execute([$simulationId]);
        $sim = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sim) throw new Exception("Simulation non trouvée ou non approuvée");

        // Récupère les dates
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime("+{$sim['duration_months']} months"));

        // Insère dans la table `pret`
        $insert = $db->prepare("INSERT INTO pret (
            id_client, id_type_pret, id_fonds, montant, date_debut, date_fin, statut, commentaire
        ) VALUES (?, ?, ?, ?, ?, ?, 'actif', 'Créé depuis une simulation approuvée')");
        
        $insert->execute([
            $sim['client_id'],
            $sim['loan_type_id'],
            $fundId,
            $sim['amount'],
            $start,
            $end
        ]);

        return $db->lastInsertId();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT ls.*, CONCAT(c.nom, ' ', c.prenom) AS client_name, lt.name AS loan_type_name, lt.interest_rate
                            FROM loan_simulations ls
                            JOIN client c ON ls.client_id = c.id
                            JOIN loan_types lt ON ls.loan_type_id = lt.id
                            ORDER BY ls.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT ls.*, CONCAT(c.nom, ' ', c.prenom) AS client_name, lt.name AS loan_type_name, lt.interest_rate
                              FROM loan_simulations ls
                              JOIN client c ON ls.client_id = c.id
                              JOIN loan_types lt ON ls.loan_type_id = lt.id
                              WHERE ls.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByClient($client_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT ls.*, lt.name AS loan_type_name
                              FROM loan_simulations ls
                              JOIN loan_types lt ON ls.loan_type_id = lt.id
                              WHERE ls.client_id = ?
                              ORDER BY ls.created_at DESC");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($id, $status) {
        $allowed = ['pending', 'approved', 'rejected'];
        if (!in_array($status, $allowed)) {
            throw new InvalidArgumentException("Statut invalide");
        }

        $db = getDB();
        $stmt = $db->prepare("UPDATE loan_simulations SET validation_status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM loan_simulations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getStats() {
        $db = getDB();
        $stmt = $db->query("SELECT COUNT(*) AS total, SUM(amount) AS total_amount, AVG(duration_months) AS avg_duration FROM loan_simulations");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
