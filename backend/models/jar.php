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
    }

    ?>
