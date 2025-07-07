<?php
require_once __DIR__ . '/../models/Interest.php';

class InterestController {
    private $model;

    public function __construct() {
        $this->model = new Interest();
    }

    public function getInterestEarned($start, $end) {
        return $this->model->getInterestEarnedByMonth($start, $end);
    }
}
