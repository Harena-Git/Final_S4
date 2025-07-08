<?php
require_once __DIR__ . '/../models/Remboursement.php';

class RemboursementController {
    public static function create() {
        $data = Flight::request()->data;

        $required_fields = ['client_loan_id', 'montant', 'date_prevue', 'numero_echeance', 'montant_interet', 'montant_principal', 'solde_restant'];
        foreach ($required_fields as $field) {
            if (!isset($data->$field)) {
                Flight::json(['error' => "Le champ $field est requis"], 400);
                return;
            }
        }

        try {
            $id = Remboursement::create(
                $data->client_loan_id,
                $data->montant,
                $data->date_prevue,
                $data->date_effectue ?? null,
                $data->statut ?? 'en attente',
                $data->numero_echeance,
                $data->delai_premier_remboursement ?? 0,
                $data->montant_interet,
                $data->montant_principal,
                $data->solde_restant
            );
            Flight::json(['message' => 'Remboursement enregistré avec succès', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getAll() {
        try {
            $remboursements = Remboursement::getAll();
            Flight::json($remboursements);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function getByLoan($client_loan_id) {
        try {
            $remboursements = Remboursement::getByLoan($client_loan_id);
            Flight::json($remboursements);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function update($id) {
        $data = Flight::request()->data;

        try {
            Remboursement::update($id, $data);
            Flight::json(['message' => 'Remboursement mis à jour avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            Remboursement::delete($id);
            Flight::json(['message' => 'Remboursement supprimé avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}