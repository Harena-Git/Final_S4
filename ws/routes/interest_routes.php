<?php
use Flight;

Flight::route('GET /interest_earned', function(){
    $start = Flight::query('start');
    $end = Flight::query('end');
    $controller = new InterestController();
    $result = $controller->getInterestEarned($start, $end);
    Flight::json($result);
});
