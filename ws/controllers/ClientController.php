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

    public static function getById($id) {
        try {
            $client = Client::getById($id);
            if ($client) {
                Flight::json($client);
            } else {
                Flight::json(['error' => 'Client non trouvé'], 404);
            }
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function create() {
        $data = Flight::request()->data;

        if (!isset($data->nom) || empty(trim($data->nom))) {
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
            Flight::json(['message' => 'Client créé avec succès', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function update($id) {
        $data = Flight::request()->data;

        if (!isset($data->nom) || empty(trim($data->nom))) {
            Flight::json(['error' => 'Le nom est requis'], 400);
            return;
        }

        try {
            Client::update(
                $id,
                trim($data->nom),
                trim($data->prenom ?? ''),
                trim($data->email ?? ''),
                intval($data->age ?? 0)
            );
            Flight::json(['message' => 'Client mis à jour avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            Client::delete($id);
            Flight::json(['message' => 'Client supprimé avec succès']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}