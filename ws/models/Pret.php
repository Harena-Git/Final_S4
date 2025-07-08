<?php
require_once __DIR__ . '/../db.php';

class Pret {
    public static function create($client_id, $loan_type_id, $fund_id, $amount, $start_date, $end_date = null, $commentaire = null) {
        $db = getDB();

        $stmt = $db->prepare("INSERT INTO pret 
            (id_client, id_type_pret, id_fonds, montant, date_debut, date_fin, commentaire) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        return $stmt->execute([
            $client_id,
            $loan_type_id,
            $fund_id,
            $amount,
            $start_date,
            $end_date,
            $commentaire
        ]);
    }
}
