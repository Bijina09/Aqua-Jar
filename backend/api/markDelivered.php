<?php
    require_once __DIR__ . "/../controllers/OrderController.php";

    $markDelivered = new OrderController();

    $markDelivered->markDelivered();

?>