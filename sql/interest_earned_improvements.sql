-- Add index on start_date for performance
CREATE INDEX idx_client_loans_start_date ON client_loans(start_date);

-- Improved query to calculate interest earned per month with filtering
-- Replace '2023-01-01' and '2023-12-31' with actual date strings in 'YYYY-MM-DD' format before running

SELECT 
    DATE_FORMAT(start_date, '%Y-%m') AS month,
    SUM(amount * interest_rate / 100) AS interest_earned
FROM client_loans
JOIN loan_types ON client_loans.loan_type_id = loan_types.id
WHERE start_date BETWEEN '2023-01-01' AND '2023-12-31'
GROUP BY month
ORDER BY month ASC;
