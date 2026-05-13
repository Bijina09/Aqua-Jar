<?php

    require_once __DIR__ . "/../controllers/CustomerController.php";

    $updateCustomer = new CustomerController();

    $updateCustomer->updateCustomer();

?>