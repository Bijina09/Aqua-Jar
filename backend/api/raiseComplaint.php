<?php
    require_once __DIR__ . "/../controllers/ComplaintController.php";

    $raiseComplaint = new ComplaintController();

    $raiseComplaint->raiseComplaint();

?>