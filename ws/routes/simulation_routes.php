<?php
// Créer une simulation
Flight::route('POST /loan_simulations', ['SimulationController', 'create']);

// Récupérer toutes les simulations
Flight::route('GET /loan_simulations', ['SimulationController', 'getAll']);

// Récupérer les simulations par client
Flight::route('GET /loan_simulations/@client_id', ['SimulationController', 'getByClient']);

// Mettre à jour le statut d'une simulation
Flight::route('PUT /loan_simulations/@id', ['SimulationController', 'updateStatus']);

// Supprimer une simulation
Flight::route('DELETE /loan_simulations/@id', ['SimulationController', 'delete']);
?>
