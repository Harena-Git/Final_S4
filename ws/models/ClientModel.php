<?php
class ClientModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllClients() {
        $stmt = $this->db->query("SELECT * FROM client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientById($id) {
        $stmt = $this->db->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createClient($data) {
        $stmt = $this->db->prepare("INSERT INTO client (nom, prenom, cin, telephone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['nom'], $data['prenom'], $data['cin'], $data['telephone']]);
        return $this->db->lastInsertId();
    }

    public function updateClient($id, $data) {
        $stmt = $this->db->prepare("UPDATE client SET nom = ?, prenom = ?, cin = ?, telephone = ? WHERE id = ?");
        $stmt->execute([$data['nom'], $data['prenom'], $data['cin'], $data['telephone'], $id]);
        return $stmt->rowCount();
    }

    public function deleteClient($id) {
        $stmt = $this->db->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}