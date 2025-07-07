<?php
Flight::route('POST /loan_types', function() {
    $data = Flight::request()->data;

    // Validate input
    if (!isset($data->name) || !is_string($data->name) || empty(trim($data->name))) {
        Flight::json(['error' => 'Le nom du type de prêt est requis'], 400);
        return;
    }
    if (!isset($data->interest_rate) || !is_numeric($data->interest_rate)) {
        Flight::json(['error' => 'Le taux d\'intérêt est requis et doit être un nombre'], 400);
        return;
    }

    $name = trim($data->name);
    $interest_rate = floatval($data->interest_rate);

    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO loan_types (name, interest_rate) VALUES (?, ?)");
        $stmt->execute([$name, $interest_rate]);
        $response = ['message' => 'Type de prêt ajouté avec succès', 'id' => $db->lastInsertId()];
        Flight::json($response);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /loan_types', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM loan_types");
        $loan_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::json($loan_types);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
