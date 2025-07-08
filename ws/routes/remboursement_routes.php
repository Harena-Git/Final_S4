<?php
Flight::route('POST /remboursements', function() {
    RemboursementController::create();
});

Flight::route('GET /remboursements/loan/@loanId', function($loanId) {
    RemboursementController::getByLoan($loanId);
});