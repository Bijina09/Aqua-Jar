<?php

    require_once __DIR__ . "/../../controllers/DistributorController.php";

    $getActivity = new DistributorController();

    $getActivity->getRecentOrders();

?>