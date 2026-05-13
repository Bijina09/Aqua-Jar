<?php

    require_once __DIR__ . "/../config/db.php";

    class Distributor {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function register($name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password) {

            $sql = "INSERT INTO distributor (name, address, phone, PAN_NO, supplier, supplier_PAN, email, password_hashed) VALUES (?,?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssssssss", $name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password);

            return $stmt->execute();

        }

        public function login($email) {

            $sql = "SELECT * FROM distributor WHERE email = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

            // //To use fetch_assoc(), Convert statement into object
            // $stmt->store_result();

            // if($stmt->num_rows === 0) {
            //     return null;
            // }

            // $stmt->bind_result($id, $name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password_hashed);

            // $stmt->fetch();

            // return [
            //     'id' => $id,
            //     'name'=> $name,
            //     'address'=> $address,
            //     'email'=> $email,
            //     'PAN_NO'=> $PAN_NO,
            //     'supplier'=> $supplier,
            //     'email'=> $email,
            //     'password_hashed' => $password_hashed
            // ]; 

        }

        public function emailExists($email) {

            //Optimized to be more faster selecting only id
            $sql = "SELECT id FROM customer WHERE email = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $stmt->store_result();

            //Return true or false
            return $stmt->num_rows > 0;

        }

         public function fetchData($id) {

            $sql = "SELECT name,address,phone,PAN_NO,supplier,supplier_PAN,email FROM distributor WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

         }

         public function editData($id, $name, $address, $phone, $panNo, $supplierName,
                     $supplierPanNo,$email) {

            $sql = "UPDATE distributor SET
            name = ?, address = ?, phone = ?,
            PAN_NO = ?, supplier = ?,
            supplier_PAN = ?, email = ?  WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("sssssssi", $name, $address, $phone, $panNo ,$supplierName,
                     $supplierPanNo, $email, $id);

            return $stmt->execute();
        }





    }

    ?>