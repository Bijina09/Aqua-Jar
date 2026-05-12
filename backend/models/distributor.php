<?php

    require_once "/../config/db.php";

    class Distributor {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function register($name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password) {

            $sql = "INSERT INTO distributor (name, address, phone, PAN_NO, supplier, supplier_PAN, email, password) VALUES (?,?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssssssss", $name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password);

            return $stmt->execute();

        }

        public function login($email) {

            $sql = "SELECT * FROM distributor WHERE email = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $email);

            $stmt->execute();

            //To use fetch_assoc(), Convert statement into object
            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

        public function emailExists($email) {

            //Optimized to be more faster selecting only id
            $sql = "SELECT id FROM customer WHERE email = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $email);

            $stmt->execute();

            //Return true or false
            return $stmt->get_result->num_rows > 0;

        }




    }

    ?>