<?php
require_once __DIR__ . '/../models/LoanTypes.php';

class LoanTypesController {
    public static function create() {
        $data = Flight::request()->data;

        if (!isset($data->name) || !is_string($data->name) || empty(trim($data->name))) {
            Flight::json(['error' => 'Le nom du type de prêt est requis'], 400);
            return;
        }
        if (!isset($data->interest_rate) || !is_numeric($data->interest_rate)) {
            Flight::json(['error' => 'Le taux d\'intérêt est requis et doit être un nombre'], 400);
            return;
        }

        $name = trim($data->name);
        $interest_rate = floatval($data->interest_rate);

        try {
            $id = LoanTypes::create($name, $interest_rate);
            Flight::json(['message' => 'Type de prêt ajouté avec succès', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getAll() {
        try {
            $loan_types = LoanTypes::getAll();
            Flight::json($loan_types);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}
