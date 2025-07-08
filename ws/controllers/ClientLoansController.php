<?php
require_once __DIR__ . '/../models/ClientLoans.php';

class ClientLoansController {
    public static function create() {
        $data = Flight::request()->data;

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
        if (!isset($data->start_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data->start_date)) {
            Flight::json(['error' => 'start_date est requis et doit être au format YYYY-MM-DD'], 400);
            return;
        }

        $client_id = intval($data->client_id);
        $loan_type_id = intval($data->loan_type_id);
        $amount = floatval($data->amount);
        $start_date = $data->start_date;
        $end_date = isset($data->end_date) ? $data->end_date : null;
        $status = isset($data->status) ? $data->status : 'active';

        try {
            $id = ClientLoans::create($client_id, $loan_type_id, $amount, $start_date, $end_date, $status);
            Flight::json(['message' => 'Prêt client ajouté avec succès', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getAll() {
        try {
            $client_loans = ClientLoans::getAll();
            Flight::json($client_loans);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ Méthode pour obtenir tous les prêts d’un client donné
    public static function getByClient($client_id) {
        try {
            $client_loans = ClientLoans::getByClient($client_id);
            Flight::json($client_loans);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function update($id) {
        $data = Flight::request()->data;

        try {
            ClientLoans::update($id, $data);
            Flight::json(['message' => 'Prêt client mis à jour avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            ClientLoans::delete($id);
            Flight::json(['message' => 'Prêt client supprimé avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}
