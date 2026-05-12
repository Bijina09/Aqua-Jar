<?php

    require_once __DIR__ . "/../models/Customer.php";
    require_once __DIR__ . "/../config/db.php";
    //controller passes it
    
    class CustomerController{

        public function register() {

            header("Content-Type: application/json");

            //Blind PHP function is isolated, does not see outside variables(global) so we bring it inside
            global $conn;

            //Safe input check
            if (
                empty(trim($_POST['name'])) ||
                empty(trim($_POST['address'])) ||
                empty(trim($_POST['phone'])) ||
                empty(trim($_POST['email'])) ||
                empty(trim($_POST['password']))
            ) {
                echo json_encode([
                "status" => "error",
                "message" => "All fields are required"
                ]);
                exit;
              }
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            
            $customer = new Customer($conn);

            if($customer->emailExists($email)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Email already exists"
                ]);
                exit;
            }

           $result = $customer->register($name, $address, $phone, $email, $password);
            
            if ($result) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Registration successful"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Registration failed"
                ]);
            }
        
            exit;
        }

        public function login(){

            header("Content-Type: application/json");

            global $conn;

            //Check fields

            if(
                empty(trim($_POST['email'])) ||
                empty(trim($_POST['password']))
            ) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Missing fields"
                ]);
                exit;
            }

            $customer = new Customer($conn);

            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $customer->login($email);

            if(!$result) {
                echo json_encode([
                    "status" => "error",
                    "message" => "User not found"
                ]);
                exit;
           }

            //password_hash creates new hash everytime so used function
            if(password_verify($password, $result['password_hashed'])){
                echo json_encode([
                    "status" => "success",
                    "message" => "Login successful"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Incorrect credentials"
                ]);
            }
            exit;

        }
   
    }

?>