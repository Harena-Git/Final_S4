<?php
require 'vendor/autoload.php';
require 'db.php';

// Chargement des modèles
require 'ws/models/ClientModel.php';
$clientModel = new ClientModel(getDB());

// Chargement des contrôleurs
require 'ws/controllers/ClientController.php';
$clientController = new ClientController($clientModel);

// Routes API
Flight::route('GET /api/clients', [$clientController, 'getAll']);
Flight::route('GET /api/clients/@id', [$clientController, 'getById']);
Flight::route('POST /api/clients', [$clientController, 'create']);
Flight::route('PUT /api/clients/@id', [$clientController, 'update']);
Flight::route('DELETE /api/clients/@id', [$clientController, 'delete']);

// Route pour l'interface web
Flight::route('GET /clients', function() use ($clientModel) {
    $clients = $clientModel->getAllClients();
    Flight::render('clients/list.php', ['clients' => $clients]);
});

Flight::start();