<?php
require 'vendor/autoload.php';
require 'db.php';

// ⚠️ Inclure les modèles et contrôleurs nécessaires
require 'models/Simulation.php';
require 'controllers/SimulationController.php';

// Routes
require 'routes/fonds_routes.php';
require 'routes/loan_types_routes.php';
require 'routes/client_loans_routes.php';
require 'routes/simulation_routes.php';
require 'routes/remboursement_routes.php';
require 'routes/client_routes.php';

// CORS (IMPORTANT - placer avant tout traitement)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

Flight::start();
