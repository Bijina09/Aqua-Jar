<?php
    require_once __DIR__ . "/../controllers/ComplaintController.php";

    $viewComplaints = new ComplaintController();

    $viewComplaints->viewComplaints();

?>