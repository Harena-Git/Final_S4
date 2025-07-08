<?php
Flight::route('POST /remboursements', ['RemboursementController', 'create']);
Flight::route('GET /remboursements', ['RemboursementController', 'getAll']);
Flight::route('GET /remboursements/loan/@client_loan_id', ['RemboursementController', 'getByLoan']);
Flight::route('PUT /remboursements/@id', ['RemboursementController', 'update']);
Flight::route('DELETE /remboursements/@id', ['RemboursementController', 'delete']);