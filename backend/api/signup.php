<?php
    header("Content-Type: application/json");

    require_once __DIR__ . "/../controllers/CustomerController.php";

    $controller = new CustomerController();

    $controller->register();
var_dump($result);
exit;
?>
    