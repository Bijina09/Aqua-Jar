<?php
    require_once __DIR__ . "/../controllers/OrderController.php";

    $ordersHistory = new OrderController();

    $ordersHistory->ordersHistory();

?>