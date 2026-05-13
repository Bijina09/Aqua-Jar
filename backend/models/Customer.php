<?php
    //Controller passes dbconnection

    class Customer {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function register($name, $address, $phone, $email, $password) {

            $sql = "INSERT INTO customer (name, address, phone, email, password_hashed) VALUES (?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("sssss", $name, $address, $phone, $email, $password);

            return $stmt->execute();

        }

        public function login($email) {

            $sql = "SELECT id,name,address,email,password_hashed FROM customer WHERE email = ?";
            
            //prepare statement object(like a template  + placeholder)
            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("s", $email);

            //run query
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();


            // $stmt->store_result();

            // if($stmt->num_rows === 0) {
            //     return null;
            // }

            // $stmt->bind_result($id, $name, $address, $email, $password_hashed);
            // $stmt->fetch();

            // return [
            //     'id' => $id,
            //     'name'=> $name,
            //     'address'=> $address,
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

            //Just store + count rows
            $stmt->store_result();

            //Return true or false
            return $stmt->num_rows > 0;

        }

        public function fetchData($id) {

            $sql = "SELECT name,address,phone,email FROM customer WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

            // $stmt->store_result();

            // if($stmt->num_rows === 0) {
            //     return null;
            // }

            // $stmt->bind_result($name, $address, $phone, $email);
            // $stmt->fetch();

            // return [
            //     'name' => $name,
            //     'address' => $address,
            //     'phone' => $phone,
            //     'email' => $email
            // ];



        }

        public function editData($id,$name,$address,$phone,$email) {

            $sql = "UPDATE customer SET
            name = ?, address = ?, phone = ?, email = ?  WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssssi", $name, $address, $phone, $email, $id);

            return $stmt->execute();
        }






    }

    ?>