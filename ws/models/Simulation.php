<?php
require_once __DIR__ . '/../db.php';

class Simulation {
    public static function create($client_id, $loan_type_id, $amount, $duration_months) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO loan_simulations (client_id, loan_type_id, amount, duration_months) VALUES (?, ?, ?, ?)");
        $stmt->execute([$client_id, $loan_type_id, $amount, $duration_months]);
        return $db->lastInsertId();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM loan_simulations ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByClient($client_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM loan_simulations WHERE client_id = ? ORDER BY created_at DESC");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($id, $status) {
        $allowed = ['pending', 'approved', 'rejected'];
        if (!in_array($status, $allowed)) {
            throw new Exception("Statut invalide");
        }
        $db = getDB();
        $stmt = $db->prepare("UPDATE loan_simulations SET validation_status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM loan_simulations WHERE id = ?");
        $stmt->execute([$id]);
    }
}
