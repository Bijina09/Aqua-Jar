<?php
    require_once __DIR__ . "/../../controllers/CustomerController.php";

    $getBill = new CustomerController();

    $getBill->getBill();

?>

