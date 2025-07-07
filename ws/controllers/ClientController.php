<?php
class ClientController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAll() {
        $clients = $this->model->getAllClients();
        Flight::json($clients);
    }

    public function getById($id) {
        $client = $this->model->getClientById($id);
        if ($client) {
            Flight::json($client);
        } else {
            Flight::halt(404, json_encode(['error' => 'Client non trouvé']));
        }
    }

    public function create() {
        $data = Flight::request()->data->getData();
        $id = $this->model->createClient($data);
        Flight::json(['message' => 'Client créé', 'id' => $id], 201);
    }

    public function update($id) {
        $data = Flight::request()->data->getData();
        $rows = $this->model->updateClient($id, $data);
        if ($rows > 0) {
            Flight::json(['message' => 'Client mis à jour']);
        } else {
            Flight::halt(404, json_encode(['error' => 'Client non trouvé']));
        }
    }

    public function delete($id) {
        $rows = $this->model->deleteClient($id);
        if ($rows > 0) {
            Flight::json(['message' => 'Client supprimé']);
        } else {
            Flight::halt(404, json_encode(['error' => 'Client non trouvé']));
        }
    }
}