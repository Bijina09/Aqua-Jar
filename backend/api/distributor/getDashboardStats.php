<?php

    require_once __DIR__ . "/../../controllers/DistributorController.php";

    $getDashboardStats = new DistributorController();

    $getDashboardStats->getDashboardStats();

?>