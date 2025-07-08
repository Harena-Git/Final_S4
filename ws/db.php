<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'tp_flight'; // db_s2_ETU003268
    $username = 'root'; // ETU003268
    $password = ''; // 'hRa5EPjW'

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => $e->getMessage()]));
    }
}
