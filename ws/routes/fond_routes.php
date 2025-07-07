<?php
require_once __DIR__ . '/../controllers/FondController.php';

Flight::route('GET /api/fonds', ['FondController', 'getAll']);
Flight::route('POST /api/fonds', ['FondController', 'create']);