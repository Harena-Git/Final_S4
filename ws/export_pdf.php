<?php
require_once __DIR__ . '/fpdf186/fpdf.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tp_flight', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = "SELECT * FROM client_loans";
    $stmt = $pdo->query($sql);
    $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Liste des prêts clients', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 10, 'Client', 1);
    $pdf->Cell(20, 10, 'Type', 1);
    $pdf->Cell(20, 10, 'Fond', 1);
    $pdf->Cell(30, 10, 'Montant', 1);
    $pdf->Cell(30, 10, 'Début', 1);
    $pdf->Cell(30, 10, 'Fin', 1);
    $pdf->Cell(30, 10, 'Statut', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    foreach ($loans as $loan) {
        $pdf->Cell(20, 10, $loan['client_id'], 1);
        $pdf->Cell(20, 10, $loan['loan_type_id'], 1);
        $pdf->Cell(20, 10, $loan['fund_id'], 1);
        $pdf->Cell(30, 10, $loan['amount'], 1);
        $pdf->Cell(30, 10, $loan['start_date'], 1);
        $pdf->Cell(30, 10, $loan['end_date'] ?? '-', 1);
        $pdf->Cell(30, 10, $loan['status'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'liste_prets_clients.pdf');
    exit;

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
