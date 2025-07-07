<?php
require_once __DIR__ . '/../models/Fond.php';

class FondController {
    public static function getAll() {
        $fonds = Fond::getAll();
        Flight::json($fonds);
    }

    public static function create() {
        $montant = Flight::request()->data->montant;
        if (!$montant) {
            Flight::json(['error' => 'Montant manquant'], 400);
            return;
        }
        $id = Fond::create($montant);
        Flight::json(['message' => 'Fond ajouté', 'id' => $id]);
    }
}