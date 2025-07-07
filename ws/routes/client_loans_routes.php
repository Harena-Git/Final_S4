<?php
Flight::route('POST /client_loans', function() {
    $data = Flight::request()->data;

    // Validate input
    if (!isset($data->client_id) || !is_numeric($data->client_id)) {
        Flight::json(['error' => 'client_id est requis et doit être un nombre'], 400);
        return;
    }
    if (!isset($data->loan_type_id) || !is_numeric($data->loan_type_id)) {
        Flight::json(['error' => 'loan_type_id est requis et doit être un nombre'], 400);
        return;
    }
    if (!isset($data->amount) || !is_numeric($data->amount)) {
        Flight::json(['error' => 'amount est requis et doit être un nombre'], 400);
        return;
    }
    if (!isset($data->start_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data->start_date)) {
        Flight::json(['error' => 'start_date est requis et doit être au format YYYY-MM-DD'], 400);
        return;
    }

    $client_id = intval($data->client_id);
    $loan_type_id = intval($data->loan_type_id);
    $amount = floatval($data->amount);
    $start_date = $data->start_date;
    $end_date = isset($data->end_date) ? $data->end_date : null;
    $status = isset($data->status) ? $data->status : 'active';

    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO client_loans (client_id, loan_type_id, amount, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$client_id, $loan_type_id, $amount, $start_date, $end_date, $status]);
        $response = ['message' => 'Prêt client ajouté avec succès', 'id' => $db->lastInsertId()];
        Flight::json($response);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /client_loans', function() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client_loans");
        $client_loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::json($client_loans);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('PUT /client_loans/@id', function($id) {
    $data = Flight::request()->data;

    $fields = [];
    $values = [];

    if (isset($data->client_id) && is_numeric($data->client_id)) {
        $fields[] = 'client_id = ?';
        $values[] = intval($data->client_id);
    }
    if (isset($data->loan_type_id) && is_numeric($data->loan_type_id)) {
        $fields[] = 'loan_type_id = ?';
        $values[] = intval($data->loan_type_id);
    }
    if (isset($data->amount) && is_numeric($data->amount)) {
        $fields[] = 'amount = ?';
        $values[] = floatval($data->amount);
    }
    if (isset($data->start_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data->start_date)) {
        $fields[] = 'start_date = ?';
        $values[] = $data->start_date;
    }
    if (isset($data->end_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data->end_date)) {
        $fields[] = 'end_date = ?';
        $values[] = $data->end_date;
    }
    if (isset($data->status)) {
        $fields[] = 'status = ?';
        $values[] = $data->status;
    }

    if (empty($fields)) {
        Flight::json(['error' => 'Aucun champ valide à mettre à jour'], 400);
        return;
    }

    $values[] = intval($id);

    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE client_loans SET " . implode(', ', $fields) . " WHERE id = ?");
        $stmt->execute($values);
        Flight::json(['message' => 'Prêt client mis à jour avec succès']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /client_loans/@id', function($id) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client_loans WHERE id = ?");
        $stmt->execute([intval($id)]);
        Flight::json(['message' => 'Prêt client supprimé avec succès']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
