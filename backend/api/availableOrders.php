<?php
    require_once __DIR__ . "/../controllers/DistributorController.php";

    $availableOrders = new DistributorController();

    $availableOrders->availableOrders();

?>