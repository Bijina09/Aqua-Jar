<?php

    require_once __DIR__ . "/../models/Orders.php";
    require_once __DIR__ . "/../config/db.php";

    header("Content-Type: application/json");
    
    class OrderController{

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

        public function placeOrder() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Same comment check customer
            if(!isset($_SESSION['user_id']) ||
                $_SESSION['role'] !== "customer"
            ) {
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $order = new Orders($conn);

            $deliveryDatetime = $this->clean("delivery_datetime");
            $location = $this->clean("location");
            $quantity = $this->clean("quantity");
            $distributorId = $this->clean("distributor_id");

            //Safe input check
            if (
                empty($deliveryDatetime) ||
                empty($location) ||
                empty($quantity) ||
                empty($distributorId)
            ) {
               $this->response("error", "All fields are required");
            }

            $result = $order->placeOrder($deliveryDatetime,
            $location,
            $quantity,
            $user_id,
            $distributorId);

            if(!$result) {
                $this->response("error", "Order placement failed");
            }

            $this->response("success", "Order placed successfully");

        }

        

    }