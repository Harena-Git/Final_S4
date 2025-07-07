<?php
require_once __DIR__ . '/../db.php';

class Fond {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM fond");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($montant) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO fond (montant) VALUES (?)");
        $stmt->execute([$montant]);
        return $db->lastInsertId();
    }
}