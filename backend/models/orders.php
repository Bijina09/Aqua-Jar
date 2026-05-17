<?php

    class Orders {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function placeOrder(
            $deliveryDatetime,
            $location,
            $quantity,
            $customerId,
            $distributorId
        ) {

            $sql = "INSERT INTO orders
            (delivery_datetime, location, quantity, customer_id, distributor_id)
            VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "ssiii",
                $deliveryDatetime,
                $location,
                $quantity,
                $customerId,
                $distributorId
            );

            return $stmt->execute();
        }
    }

    ?>
