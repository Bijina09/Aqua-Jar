<?php
    require_once __DIR__ . "/../controllers/ComplaintController.php";

    $resolveComplaint = new ComplaintController();

    $resolveComplaint->resolveComplaint();

?>