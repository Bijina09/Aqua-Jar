<?php

    class Jar {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function postJar(
            $quantity,
            $price,
            $unit,
            $distributorId
        ) {

            $sql = "INSERT INTO jar
            (quantity, price, unit, distributor_id)
            VALUES (?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "iisi",
                $quantity,
                $price,
                $unit,
                $distributorId
            );

            return $stmt->execute();
        }

        //Distributor Dashboard
        public function getTotalJars($distributorId) {

            $sql = "SELECT SUM(quantity) AS total_jars
            FROM jar WHERE distributor_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $distributorId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

        //For Jar Details
        public function getJars($distributorId) {
            $sql = "SELECT quantity, price, unit
            FROM jar 
            WHERE distributor_id = ? 
            ORDER BY id DESC";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $distributorId);
            $stmt->execute();
            
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

    }

    ?>
