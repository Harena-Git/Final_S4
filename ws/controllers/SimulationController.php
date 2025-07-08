<?php
require_once __DIR__ . '/../models/Simulation.php';

class SimulationController {
    public static function create() {
        $request = Flight::request();
        $data = $request->data->getData();

        $required = ['client_id', 'loan_type_id', 'amount', 'duration_months'];
        $errors = [];

        foreach ($required as $field) {
            if (empty($data[$field]) && $data[$field] !== '0') {
                $errors[] = "Le champ $field est requis";
            }
        }

        if (!empty($errors)) {
            Flight::halt(400, json_encode([
                'success' => false,
                'errors' => $errors
            ]));
            return;
        }

        try {
            $id = Simulation::create(
                (int)$data['client_id'],
                (int)$data['loan_type_id'],
                (float)$data['amount'],
                (int)$data['duration_months']
            );

            Flight::json([
                'success' => true,
                'id' => $id,
                'message' => 'Simulation créée avec succès'
            ], 201);

        } catch (PDOException $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur de base de données',
                'detail' => $e->getMessage()
            ]));
        } catch (Exception $e) {
            Flight::halt(400, json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]));
        }
    }

    public static function getAll() {
        try {
            $simulations = Simulation::getAll();
            Flight::json([
                'success' => true,
                'data' => $simulations,
                'count' => count($simulations)
            ]);
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur lors de la récupération',
                'detail' => $e->getMessage()
            ]));
        }
    }

    public static function getById($id) {
        try {
            $simulation = Simulation::getById($id);
            if (!$simulation) {
                Flight::halt(404, json_encode([
                    'success' => false,
                    'error' => 'Simulation non trouvée'
                ]));
                return;
            }
            Flight::json([
                'success' => true,
                'data' => $simulation
            ]);
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur serveur'
            ]));
        }
    }

    public static function getByClient($client_id) {
        try {
            $simulations = Simulation::getByClient($client_id);
            Flight::json([
                'success' => true,
                'data' => $simulations,
                'count' => count($simulations)
            ]);
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur lors de la récupération',
                'detail' => $e->getMessage()
            ]));
        }
    }

    public static function updateStatus($id) {
        $request = Flight::request();
        $status = $request->data->validation_status ?? null;

        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            Flight::halt(400, json_encode([
                'success' => false,
                'error' => 'Statut invalide (doit être pending, approved ou rejected)'
            ]));
            return;
        }

        try {
            $success = Simulation::updateStatus($id, $status);
            Flight::json([
                'success' => $success,
                'message' => $success
                    ? 'Statut mis à jour avec succès'
                    : 'Aucune modification effectuée'
            ]);
        } catch (InvalidArgumentException $e) {
            Flight::halt(400, json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]));
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur de mise à jour'
            ]));
        }
    }

    public static function delete($id) {
        try {
            $success = Simulation::delete($id);
            Flight::json([
                'success' => $success,
                'message' => $success
                    ? 'Simulation supprimée'
                    : 'Aucune simulation supprimée'
            ]);
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur de suppression'
            ]));
        }
    }

    public static function getStats() {
        try {
            $stats = Simulation::getStats();
            Flight::json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (Exception $e) {
            Flight::halt(500, json_encode([
                'success' => false,
                'error' => 'Erreur de calcul'
            ]));
        }
    }

    // Méthode pour sauvegarder une simulation approuvée comme prêt dans la table pret
    public static function saveAsLoan($id) {
        $request = Flight::request();
        $data = $request->data->getData();

        $fund_id = $data['fund_id'] ?? null;
        if (!$fund_id) {
            Flight::halt(400, json_encode(['success' => false, 'error' => 'Fonds manquant']));
            return;
        }

        try {
            // Appelle la méthode du modèle pour sauvegarder
            $loanId = Simulation::saveToPret($id, $fund_id);
            Flight::json([
                'success' => true,
                'loan_id' => $loanId,
                'message' => "Simulation convertie en prêt"
            ]);
        } catch (Exception $e) {
            Flight::halt(400, json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]));
        }
    }

    // Exemple : méthode de calcul (à adapter selon besoin)
    public static function calculatePayment($amount, $duration, $rate) {
        if (!$amount || !$duration || !$rate) {
            Flight::halt(400, json_encode([
                'success' => false,
                'error' => 'Paramètres manquants pour le calcul'
            ]));
            return;
        }
        // Exemple calcul simple mensualité (annuité fixe)
        $monthlyRate = $rate / 100 / 12;
        $payment = ($amount * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$duration));
        Flight::json([
            'success' => true,
            'monthly_payment' => round($payment, 2)
        ]);
    }
}
