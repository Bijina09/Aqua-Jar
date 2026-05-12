<?php
    
    require_once __DIR__ . "/../controllers/CustomerController.php";

    header("Content-Type: application/json");
    
    $controller = new CustomerController();

    $controller->login();

?>