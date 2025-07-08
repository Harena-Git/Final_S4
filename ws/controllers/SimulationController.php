<?php
require_once __DIR__ . '/../models/Simulation.php';

class SimulationController {
    public static function create() {
        $data = Flight::request()->data;

        // Validation simple
        if (!isset($data->client_id) || !is_numeric($data->client_id)) {
            Flight::json(['error' => 'client_id est requis et doit être un nombre'], 400);
            return;
        }
        if (!isset($data->loan_type_id) || !is_numeric($data->loan_type_id)) {
            Flight::json(['error' => 'loan_type_id est requis et doit être un nombre'], 400);
            return;
        }
        if (!isset($data->amount) || !is_numeric($data->amount)) {
            Flight::json(['error' => 'amount est requis et doit être un nombre'], 400);
            return;
        }
        if (!isset($data->duration_months) || !is_numeric($data->duration_months)) {
            Flight::json(['error' => 'duration_months est requis et doit être un nombre'], 400);
            return;
        }

        try {
            $id = Simulation::create(
                intval($data->client_id),
                intval($data->loan_type_id),
                floatval($data->amount),
                intval($data->duration_months)
            );
            Flight::json(['message' => 'Simulation de prêt créée', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getAll() {
        try {
            $simulations = Simulation::getAll();
            Flight::json($simulations);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getByClient($client_id) {
        try {
            $simulations = Simulation::getByClient($client_id);
            Flight::json($simulations);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function updateStatus($id) {
        $data = Flight::request()->data;
        if (!isset($data->validation_status)) {
            Flight::json(['error' => 'validation_status est requis'], 400);
            return;
        }

        try {
            Simulation::updateStatus($id, $data->validation_status);
            Flight::json(['message' => 'Statut de la simulation mis à jour']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            Simulation::delete($id);
            Flight::json(['message' => 'Simulation supprimée']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}
