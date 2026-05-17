<?php
    require_once __DIR__ . "/../controllers/OrderController.php";

    $placeOrder = new OrderController();

    $placeOrder->placeOrder();

?>