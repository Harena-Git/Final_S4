<?php
require_once __DIR__ . '/../models/Remboursement.php';

class RemboursementController {
    public static function create() {
        $data = Flight::request()->data;

        // Validation des données
        $requiredFields = ['client_loan_id', 'montant', 'date_prevue', 'numero_echeance'];
        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                Flight::json(['error' => "Le champ $field est requis"], 400);
                return;
            }
        }

        // Calcul du solde restant (à implémenter selon votre logique métier)
        $solde_restant = $data->montant; // Exemple simplifié

        $remboursementData = [
            'client_loan_id' => intval($data->client_loan_id),
            'montant' => floatval($data->montant),
            'date_prevue' => $data->date_prevue,
            'date_effectue' => $data->date_effectue ?? null,
            'statut' => $data->statut ?? 'en attente',
            'numero_echeance' => intval($data->numero_echeance),
            'delai_premier_remboursement' => intval($data->delai_premier_remboursement ?? 0),
            'montant_interet' => floatval($data->montant_interet),
            'montant_principal' => floatval($data->montant_principal),
            'solde_restant' => floatval($solde_restant)
        ];

        $id = Remboursement::create($remboursementData);
        
        if ($id) {
            Flight::json(['message' => 'Remboursement enregistré avec succès', 'id' => $id]);
        } else {
            Flight::json(['error' => 'Erreur lors de l\'enregistrement'], 500);
        }
    }

    public static function getByLoan($loanId) {
        $remboursements = Remboursement::getByLoanId($loanId);
        Flight::json($remboursements);
    }
}