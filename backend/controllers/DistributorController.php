<?php

    require_once __DIR__ . "/../models/Distributor.php";
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../models/Orders.php";

    //controller passes it to distributorProfile

    header("Content-Type: application/json");
    
    class DistributorController{
        
        //For repeated JSON messages
        private function response($status, $message) {
            echo json_encode([
                    "status" => $status,
                    "message" => $message
                ]);
            exit;
        }

        public function distributorProfile() {

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

            $distributor = new distributor($conn);

            $result = $distributor->fetchData($user_id);

            if(!$result) {
                $this->response("error", "User not found");
            }

            echo json_encode([
                "status" => "success",
                "name" => $result['name'],
                "address" => $result['address'],
                "phone" => $result['phone'],
                "panNo" => $result['PAN_NO'],
                "supplierName" => $result['supplier'],
                "supplierPanNo" => $result['supplier_PAN'],
                "email" => $result['email'],
                "serviceArea" => $result['service_area']
            ]);

        }

        //Helper function
        private function clean($key) {
            //null coalescing operator(empty if does not exist so No JSON Breaking)
            return trim($_POST[$key] ?? "");
        }

        public function updateDistributor() {

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

            $distributor = new distributor($conn);

            $name = $this->clean('name');
            $address = $this->clean('address');
            $phone = $this->clean('phone');
            $email = $this->clean('email');
            $panNo = $this->clean("panNo");
            $supplierName = $this->clean("supplierName");
            $supplierPanNo = $this->clean("supplierPanNo");
            $serviceArea = $this->clean("serviceArea");

            if (
                empty($name) ||
                empty($address) ||
                empty($phone) ||
                empty($email) || 
                empty($panNo) ||
                empty($supplierName) ||
                empty($supplierPanNo) ||
                empty($serviceArea)
            ) {
                $this->response("error", "Fields cannot be empty");
            }
            $result = $distributor->editData($user_id, $name, $address, $phone, $panNo, $supplierName,
                     $supplierPanNo, $email);

            if(!$result) {
                $this->response("error", "Edit failure");
            }

            $this->response("success", "Updated successfully");

        }

        //Pending orders view
        function availableOrders(){
            global $conn;
           
            session_start();

            //If no user_id, error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "distributor"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $order = new Orders($conn);

            $result = $order->getOrders($user_id);

            if(empty($result)) {
                $this->response("error", "No orders available");
            }

            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);
        }

        function complaintsView() {}

        //Loading KPIs
        function dashboard(){}

 
    }

?>