<?php

    require_once __DIR__ . "/../models/Customer.php";
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../models/Distributor.php";
    require_once __DIR__ . "/../models/Orders.php";
    require_once __DIR__ . "/../models/Complaints.php";

    //controller passes it to customerProfile

    header("Content-Type: application/json");
    
    class CustomerController{
        
        //For repeated JSON messages
        private function response($status, $message) {
            echo json_encode([
                    "status" => $status,
                    "message" => $message
                ]);
            exit;
        }

        public function customerProfile() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $customer = new Customer($conn);

            $result = $customer->fetchData($user_id);

            if(!$result) {
                $this->response("error", "User not found");
            }

            echo json_encode([
                "status" => "success",
                "name" => $result['name'],
                "address" => $result['address'],
                "phone" => $result['phone'],
                "email" => $result['email']
            ]);

        }

        //Helper function
        private function clean($key) {
            //null coalescing operator(empty if does not exist so No JSON Breaking)
            return trim($_POST[$key] ?? "");
        }

        public function updateCustomer() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $customer = new Customer($conn);

            $name = $this->clean('name');
            $address = $this->clean('address');
            $phone = $this->clean('phone');

            if (
                empty($name) ||
                empty($address) ||
                empty($phone)
            ) {
                $this->response("error", "Fields cannot be empty");
            }
            
            $result = $customer->editData(
                $user_id,$name,$address,$phone);

            if(!$result) {
                $this->response("error", "Update Failed");
            }

            $this->response("success", "Updated succcesfully"); 

        }

        //Viewing Jars only for ordering it will go to OrderController
        public function browseJars() {

            global $conn;
           
            session_start();

            //If no user_id, error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $distributor = new Distributor($conn);

            $customer = new Customer($conn);

            $data = $customer->fetchData($user_id);

            $address = $data['address'];

            $result = $distributor->browseAll($address);

            if(empty($result)) {
                $this->response("error", "No jar posts available");
            }

            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);

        }

        function myOrders(){

            global $conn;
           
            session_start();

            //If no user_id, error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $order = new Orders($conn);

            $result = $order->myOrders($user_id);

            if(empty($result)) {
                $this->response("error", "No ordes available");
            }

            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);

        }

        function getBill(){
            
            global $conn;
           
            session_start();

            //If no user_id, error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $orderId = $_GET['order_id'];

            $order = new Orders($conn);

            $result = $order->getBill($orderId);

            if(empty($result)) {
                $this->response("error", "Order record not found");
            }

            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);


        }


        //Loading stats
        function getDashboardStats(){
            global $conn;
           
            session_start();

            //If no user_id, error so check
            //Added role check coz same id possible between tables
            if(!isset($_SESSION['user_id']) ||
             $_SESSION['role'] !== "customer"
            ) {
                //Don't go forgetting this everytime
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $order = new Orders($conn);
            $complaints = new Complaints($conn);

            $orders_result = $order->getCustomerOrders($user_id);
            $open_complaints = $complaints->getCustomerOpenComplaints($user_id);


            if(empty($orders_result)|| empty($open_complaints)) {
                $this->response("error", "No stats available");
            }

            echo json_encode([
                "status" => "success",
                "total_orders" => (int)$orders_result['total_orders'] ?? 0,
                "arriving" => (int)$orders_result['arriving'] ?? 0,
                "delivered" => (int)$orders_result['delivered'] ?? 0,
                "open_complaints" => (int)$open_complaints['open_complaints'] ?? 0,
            ]);
        }
        

        
   
    }

?>