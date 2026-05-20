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

        function getOrders($distributorId) {

            $sql = "SELECT 
            o.id AS order_id,
            c.name AS customer_name,
            o.quantity AS quantity,
            o.location AS location,
            o.delivery_datetime AS delivery_datetime,
            o.status AS status

            FROM orders o JOIN customer c
            ON o.customer_id = c.id AND o.distributor_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $distributorId);

            $stmt->execute();

            $result = $stmt->get_result();

            $orders = [];

            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            return $orders;
        }

        function updateStatus($orderId, $orderStatus) {
            
            $sql = "UPDATE Orders SET 
            status = ? WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            //Checking if prepare failed
            if (!$stmt) {
            return false;
        }

            $stmt->bind_param("si", $orderStatus, $orderId);

            if ($stmt->execute()) {
                return $stmt->affected_rows > 0;
            }

            return false; 
        
        }

        function assignDriver($orderId, $driverName, $driverContact) {
            
            $sql = "UPDATE Orders SET 
            driver_name = ?,
            driver_contact = ?,
            status = 'out for delivery'
            WHERE id = ?"; 

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssi", $driverName, $driverContact, $orderId);

            return $stmt->execute(); 
        
        }

        function markDelivered($orderId, $status) {

            $sql = "UPDATE Orders SET
            status = ?,
            delivered_at = current_timestamp()
            WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("si", $status, $orderId);

            return $stmt->execute();

        }

        function myOrders($customerId) {

            $sql = "SELECT
            d.name AS distributor_name,
            o.quantity AS quantity,
            o.status AS status,
            o.driver_name AS driver_name,
            o.driver_contact AS driver_contact

            FROM distributor d JOIN orders o
            on d.id = o.distributor_id

            WHERE o.customer_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $customerId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            //When many lines used array
            $orders = [];

            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            return $orders;

        }

    }

    ?>
