<?php
Flight::route('GET /monthly_interests', function() {
    $start = Flight::request()->query['start'] ?? null;
    $end = Flight::request()->query['end'] ?? null;

    try {
        $db = getDB();
        
        $query = "SELECT * FROM monthly_interests WHERE 1=1";
        $params = [];
        
        if ($start) {
            $query .= " AND period >= ?";
            $params[] = $start;
        }
        
        if ($end) {
            $query .= " AND period <= ?";
            $params[] = $end;
        }
        
        $query .= " ORDER BY period";
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Formatage des données pour le graphique
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Intérêts mensuels (€)',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)'
                ]
            ]
        ];
        
        foreach ($results as $row) {
            $chartData['labels'][] = $row['period'];
            $chartData['datasets'][0]['data'][] = (float)$row['monthly_interest'];
        }
        
        Flight::json([
            'success' => true,
            'table_data' => $results ?: [],
            'chart_data' => $chartData
        ]);
        
    } catch (Exception $e) {
        Flight::json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});
// require_once __DIR__ . '/../models/ClientLoans.php';

// Flight::route('GET /monthly_interests', function() {
//     $start = Flight::request()->query['start'] ?? null; // Format: 'YYYY-MM'
//     $end = Flight::request()->query['end'] ?? null;     // Format: 'YYYY-MM'

//     try {
//         $db = getDB();
        
//         $query = "SELECT * FROM monthly_interests WHERE 1=1";
//         $params = [];
        
//         if ($start) {
//             $query .= " AND year_month >= ?";
//             $params[] = $start;
//         }
        
//         if ($end) {
//             $query .= " AND year_month <= ?";
//             $params[] = $end;
//         }
        
//         $query .= " ORDER BY year_month";
        
//         $stmt = $db->prepare($query);
//         $stmt->execute($params);
        
//         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
//         // Formatage des données pour le graphique
//         $chartData = [
//             'labels' => [],
//             'datasets' => [
//                 [
//                     'label' => 'Intérêts mensuels (€)',
//                     'data' => [],
//                     'backgroundColor' => 'rgba(54, 162, 235, 0.5)'
//                 ]
//             ]
//         ];
        
//         foreach ($results as $row) {
//             $chartData['labels'][] = $row['year_month'];
//             $chartData['datasets'][0]['data'][] = $row['monthly_interest'];
//         }
        
//         Flight::json([
//             'table_data' => $results,
//             'chart_data' => $chartData
//         ]);
        
//     } catch (Exception $e) {
//         Flight::json(['error' => $e->getMessage()], 500);
//     }
// });