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
            $distributorId,
            $jarId
        ) {

            $sql = "SELECT price from jar WHERE id=?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $jarId);

            $stmt->execute();

            $result = $stmt->get_result();

            $jar = $result->fetch_assoc();

            $unitPrice = $jar['price'];

            //Calculaing the total price
            $totalPrice = $unitPrice * $quantity;

            $sql = "INSERT INTO orders
            (delivery_datetime, location, quantity, customer_id, distributor_id, jar_id, unit_price, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "ssiiiidd",
                $deliveryDatetime,
                $location,
                $quantity,
                $customerId,
                $distributorId, 
                $jarId,
                $unitPrice,
                $totalPrice
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
            o.unit_price AS unit_price,
            j.unit AS unit,
            o.total_price AS total_price,
            o.status AS status,
            o.driver_name AS driver_name,
            o.driver_contact AS driver_contact

            FROM distributor d JOIN orders o
            ON d.id = o.distributor_id
            JOIN jar j ON j.id = o.jar_id

            WHERE o.customer_id = ?
            AND o.status != 'delivered'";

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

        function ordersHistory($customerId) {

            $sql = "SELECT
            d.name AS distributor_name,
            o.id AS order_id,
            o.quantity AS quantity,
            o.unit_price AS unit_price,
            j.unit AS unit,
            o.total_price AS total_price,
            o.status AS status,
            o.driver_name AS driver_name

            FROM distributor d JOIN orders o
            ON d.id = o.distributor_id
            JOIN jar j ON j.id = o.jar_id

            WHERE o.customer_id = ?
            AND o.status = 'delivered'";

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

        //Distributor Dashboard
        public function getTotalOrders($distributorId) {

            //COALESCE returns 0 instead of null
            $sql = "SELECT COUNT(id) AS total_orders,
            COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END)) AS pending
            FROM orders WHERE distributor_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $distributorId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

        //Getting recent Orders for distributor
        public function getRecentOrders($distributorId, $limit = 3) {
            $sql = "SELECT
            c.name AS customer_name,
            o.created_at AS created_at

            FROM orders o JOIN customer c
            ON c.id = o.customer_id
            WHERE o.distributor_id = ? 
            ORDER BY o.id DESC 
            LIMIT ?";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $distributorId, $limit);
            $stmt->execute();
            
            $result = $stmt->get_result();
            //Does the same task as while loop and array
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //Customer Dashboard
        public function getCustomerOrders($customerId) {

            //COALESCE returns 0 instead of null
            $sql = "SELECT COUNT(id) AS total_orders,
            COALESCE(SUM(CASE WHEN status = 'out for delivery' THEN 1 ELSE 0 END)) AS arriving,
            COALESCE(SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END)) AS delivered
            FROM orders WHERE customer_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $customerId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

    }

    ?>
