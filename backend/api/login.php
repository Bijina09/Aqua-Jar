<?php
    
    require_once __DIR__ . "/../controllers/AuthController.php";

    header("Content-Type: application/json");
    
    $auth = new AuthController();

    $auth->login();

?>