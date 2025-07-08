<?php
require_once __DIR__ . '/../db.php';

class Client {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client ORDER BY nom, prenom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nom, $prenom, $email, $age) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO client (nom, prenom, email, age) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $age]);
        return $db->lastInsertId();
    }

    public static function update($id, $nom, $prenom, $email, $age) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE client SET nom = ?, prenom = ?, email = ?, age = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $age, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
    }
}