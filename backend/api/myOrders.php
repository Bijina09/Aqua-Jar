<?php

    require_once __DIR__ . "/../controllers/CustomerController.php";

    $myOrders = new CustomerController();

    $myOrders->myOrders();

?>