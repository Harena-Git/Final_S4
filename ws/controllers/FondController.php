<?php
require_once __DIR__ . '/../models/Fond.php';

class FondController {
public static function getAll() {
    header('Content-Type: application/json');
    try {
        $fonds = Fond::getAll();
        echo json_encode($fonds);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

    public static function create() {
        try {
            $request = Flight::request();
            $montant = $request->data->montant;
            
            if (!isset($montant) || !is_numeric($montant)) {
                Flight::json(['error' => 'Montant invalide ou manquant'], 400);
                return;
            }
            
            $id = Fond::create($montant);
            Flight::json(['message' => 'Fond ajouté', 'id' => $id], 201);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}