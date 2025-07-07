<?php
require_once __DIR__ . '/../ws/db.php';

class Interest {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getInterestEarnedByMonth($start, $end) {
        $query = "
            SELECT 
                DATE_FORMAT(start_date, '%Y-%m') AS month,
                SUM(amount * interest_rate / 100) AS interest_earned
            FROM client_loans
            JOIN loan_types ON client_loans.loan_type_id = loan_types.id
            WHERE start_date BETWEEN :start AND :end
            GROUP BY month
            ORDER BY month ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
