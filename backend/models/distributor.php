<?php

    class Distributor {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function register($name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $service_area, $email, $password) {

            $sql = "INSERT INTO distributor (name, address, phone, PAN_NO, supplier, supplier_PAN, email, password_hashed, service_area) VALUES (?,?,?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("sssssssss", $name, $address, $phone, $PAN_NO, $supplier, $supplier_PAN, $email, $password, $service_area);

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

            $sql = "SELECT name,address,phone,PAN_NO,supplier,supplier_PAN,email,service_area FROM distributor WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

         }

         public function editData($id, $name, $address, $phone, $panNo, $supplierName,
                     $supplierPanNo,$email, $service_area) {

            $sql = "UPDATE distributor SET
            name = ?, address = ?, phone = ?,
            PAN_NO = ?, supplier = ?,
            supplier_PAN = ?, email = ?, service_area = ?   WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssssssssi", $name, $address, $phone, $panNo ,$supplierName,
                     $supplierPanNo, $email, $service_area, $id);

            return $stmt->execute();
        }

        public function browseAll($serviceArea) {

            $sql = "SELECT
            d.id AS distributor_id,
            d.name AS distributor_name,  
            j.unit AS unit,
            j.price AS price,
            j.quantity AS stock,
            d.service_area AS service_area,

            CASE
            WHEN d.service_area = ? THEN 1
            ELSE 2
            END as priority

            FROM distributor d
            JOIN jar j ON d.id = j.distributor_id
            ORDER BY priority ASC, j.price ASC
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $serviceArea);

            $stmt->execute();

            $result = $stmt->get_result();

            $distributors = [];

            while($row = $result->fetch_assoc()) {
                $distributors[] = $row;
            }

            return $distributors;

        }


    }

    ?>