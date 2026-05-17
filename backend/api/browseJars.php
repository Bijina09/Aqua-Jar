<?php

    require_once __DIR__ . "/../controllers/CustomerController.php";

    $browseJars = new CustomerController();

    $browseJars->browseJars();

?>