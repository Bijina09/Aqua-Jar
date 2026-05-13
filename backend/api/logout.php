<?php 
    session_start();
    session_destroy();

    header("Content-Type: application/json");

    echo json_encode([
        "status" => "succcess",
        "message" => "Logout successfull"
    ]);
    exit;
?>