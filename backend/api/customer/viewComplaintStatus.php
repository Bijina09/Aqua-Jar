<?php
    require_once __DIR__ . "/../../controllers/ComplaintController.php";

    $complaintStatus = new ComplaintController();

    $complaintStatus->getComplaintStatus();

?>