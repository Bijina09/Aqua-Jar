<?php

    require_once __DIR__ . "/../controllers/CustomerController.php";

    $customerProfile = new CustomerController();

    $customerProfile->customerProfile();

?>