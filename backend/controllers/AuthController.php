<?php

    require_once __DIR__ . "/../models/Customer.php";
    require_once __DIR__ . "/../models/Distributor.php";
    require_once __DIR__ . "/../config/db.php";

    class AuthController{

        private function response($status, $message, $role = null) {
            echo json_encode([
                    "status" => $status,
                    "message" => $message,
                    "role" => $role
                ]);
                exit;

        }

        //Login logic (Customer + Distributor)
        public function login(){

            header("Content-Type: application/json");

            global $conn;

            //Check fields

            if(
                empty(trim($_POST['email'])) ||
                empty(trim($_POST['password']))
            ) {
                $this->response("error", "Missing fields");
            }

            $customerModel = new Customer($conn);
            $distributorModel = new Distributor($conn);

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $customerModel->login($email);
            $role = "customer";

            if(!$user) {
                $user = $distributorModel->login($email);
                $role = "distributor";
            } 
            
            if(!$user) {
                $this->response("error", "User not found");
            }

            //password_hash creates new hash everytime so used function
            if(!password_verify($password, $user['password_hashed'])){
                $this->response("error", "Incorrect credentials");
            }
            
            //Storing user info in session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $user['name'];

            if($role === "distributor") {
                $_SESSION['service_area'] = $user['service_area'];

            }

            $this->response("success", "Login succesfull", $role);
          
        }

        //Helper function
        private function clean($key) {
            //null coalescing operator(empty if does not exist so No JSON Breaking)
            return trim($_POST[$key] ?? "");
        }

        //Signup logic (Customer + Distributor)
        public function register() {

            header("Content-Type: application/json");

            //Blind PHP function is isolated, does not see outside variables(global) so we bring it inside
            global $conn;

            if(!isset($_POST['role'])) {
                $this->response("error", "Role is required");
            }

            $role = $_POST['role'];

            $name = $this->clean("name");
            $address = $this->clean("address");
            $phone = $this->clean("phone");
            $email = $this->clean("email");
            $password = $this->clean("password");

            //Safe input check
            if (
                empty($name) ||
                empty($address) ||
                empty($phone) ||
                empty($email) ||
                empty($password)
            ) {
               $this->response("error", "All fields are required");
            }

            $password = password_hash($password,PASSWORD_DEFAULT);

            if($role === "customer") {
          
                $customerModel = new Customer($conn);

                if($customerModel->emailExists($email)) {
                    $this->response("error", "Email already exists");
                }

                $result = $customerModel->register(
                    $name, $address, $phone, $email, $password);
                
                if ($result) {
                    $this->response("success", "Registration successfull");
                } else {
                    $this->response("error", "Registration failed");
                }
            } else if ($role === "distributor") {

                $panNo = $this->clean("panNo");
                $supplierName = $this->clean("supplierName");
                $supplierPanNo = $this->clean("supplierPanNo");
                $serviceArea = $this->clean("serviceArea");

                //Safe input check for distributor additional fields
                if (
                    empty($panNo) ||
                    empty($supplierName) ||
                    empty($supplierPanNo) ||
                    empty($serviceArea)
                ) {
                    $this->response("error", "All fields are required");
                }
                
                $distributorModel = new Distributor($conn);

                if($distributorModel->emailExists($email)) {
                    $this->response("error", "Email already exists");
                }

                $result = $distributorModel->register(
                    $name, $address, $phone, $panNo, $supplierName,
                     $supplierPanNo, $serviceArea, $email, $password);
                
                if ($result) {
                    $this->response("success", "Registration successfull");
                } else {
                    $this->response("error", "Registration failed");
                }
            } else {
                $this->response("error", "Invalid role");
            }

        }

    }
 ?>