<?php

    require_once __DIR__ . "/../../controllers/CustomerController.php";

    $getDashboardStats = new CustomerController();

    $getDashboardStats->getDashboardStats();

?>