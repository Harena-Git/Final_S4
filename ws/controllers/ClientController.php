<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {
    public static function getAll() {
        try {
            $clients = Client::getAll();
            Flight::json($clients);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function create() {
        $data = Flight::request()->data;

        if (empty($data->nom)) {
            Flight::json(['error' => 'Le nom est requis'], 400);
            return;
        }

        try {
            $id = Client::create(
                trim($data->nom),
                trim($data->prenom ?? ''),
                trim($data->email ?? ''),
                intval($data->age ?? 0)
            );
            Flight::json(['message' => 'Client créé', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}