<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'db.php';

// Définir les routes API avant tout
require 'routes/etudiant_routes.php';
require 'routes/fond_routes.php';

// Route pour la page d'accueil
Flight::route('GET /', function() {
    Flight::sendFile('index.html');
});

// Gestion des erreurs 404 pour les API
Flight::map('notFound', function() {
    if (strpos(Flight::request()->url, '/api/') === 0) {
        Flight::json(['error' => 'Endpoint non trouvé'], 404);
    } else {
        Flight::sendFile('index.html');
    }
});

Flight::start();