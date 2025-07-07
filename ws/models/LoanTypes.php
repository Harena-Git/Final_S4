<?php
require_once __DIR__ . '/../db.php';

class LoanTypes {
    public static function create($name, $interest_rate) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO loan_types (name, interest_rate) VALUES (?, ?)");
        $stmt->execute([$name, $interest_rate]);
        return $db->lastInsertId();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM loan_types");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
