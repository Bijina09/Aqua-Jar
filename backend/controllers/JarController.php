<?php

    require_once __DIR__ . "/../models/Jar.php";
    require_once __DIR__ . "/../config/db.php";

    header("Content-Type: application/json");
    
    class JarController{

        //Helper function
        private function clean($key) {
            //null coalescing operator(empty if does not exist so No JSON Breaking)
            return trim($_POST[$key] ?? "");
        }
        
        //For repeated JSON messages
        private function response($status, $message) {
            echo json_encode([
                    "status" => $status,
                    "message" => $message
                ]);
            exit;
        }

        public function postJar() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Same comment check customer
            if(!isset($_SESSION['user_id']) ||
                $_SESSION['role'] !== "distributor"
            ) {
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $jar = new Jar($conn);

            $quantity = $this->clean("quantity");
            $price = $this->clean("price");
            $unit = $this->clean("unit");

            //Safe input check
            if (
                empty($unit) ||
                empty($price) ||
                empty($quantity)
            ) {
               $this->response("error", "All fields are required");
            }

            $result = $jar->postJar($quantity,
                $price,
                $unit,
                $user_id);

            if(!$result) {
                $this->response("error", "Order placement failed");
            }

            $this->response("success", "Order placed successfully");

        }

        

    }