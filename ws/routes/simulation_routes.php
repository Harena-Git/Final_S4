<?php
Flight::route('POST /loan_simulations', function(){
    $controller = new SimulationController();
    $controller->create(); // envoie la réponse JSON directement
});

Flight::route('GET /loan_simulations', function(){
    $controller = new SimulationController();
    $controller->getAll();
});

Flight::route('GET /loan_simulations/@id', function($id){
    $controller = new SimulationController();
    $controller->getById($id);
});

Flight::route('GET /loan_simulations/client/@client_id', function($client_id){
    $controller = new SimulationController();
    $controller->getByClient($client_id);
});

Flight::route('PUT /loan_simulations/@id/status', function($id){
    $controller = new SimulationController();
    $controller->updateStatus($id);
});

Flight::route('DELETE /loan_simulations/@id', function($id){
    $controller = new SimulationController();
    $controller->delete($id);
});

Flight::route('GET /loan_simulations/stats', function(){
    $controller = new SimulationController();
    $controller->getStats();
});

Flight::route('GET /loan_simulations/calculate', function(){
    $amount = Flight::query('amount');
    $duration = Flight::query('duration');
    $rate = Flight::query('rate');

    $controller = new SimulationController();
    $controller->calculatePayment($amount, $duration, $rate);
});

// Convertir simulation en prêt
Flight::route('POST /loan_simulations/@id/save', function($id){
    $controller = new SimulationController();
    $controller->saveAsLoan($id);
});
Flight::route('POST /loan_simulations/@id/save', function($id){
    $controller = new SimulationController();
    $controller->saveAsLoan($id);
});
