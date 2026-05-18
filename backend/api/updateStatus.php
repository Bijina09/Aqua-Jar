<?php

    require_once __DIR__ . "/../controllers/OrderController.php";

    $updateStatus = new OrderController();

    $updateStatus->updateStatus();

?>