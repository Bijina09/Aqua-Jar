<?php
    //Controller passes dbconnection

    class Complaints {

        private $conn;

        //Connection is passed (Dependency Injection)
        public function __construct($dbconnection) {
            $this->conn = $dbconnection;  

        }

        public function raiseComplaint($order_id,
            $message,
            $imagePath) {

            $sql = "SELECT customer_id, distributor_id FROM
            orders WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $order_id);

            $stmt->execute();

            $result = $stmt->get_result();

            $order = $result->fetch_assoc();

            $customer_id = $order['customer_id'];
            $distributor_id = $order['distributor_id'];

            $sql = "INSERT INTO complaints (order_id,
            customer_id, distributor_id, message, image)
            VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("iiiss",
            $order_id,
            $customer_id, 
            $distributor_id,
            $message,
            $imagePath);

            return $stmt->execute();

        }

        //Distibutor
        public function viewComplaints($user_id) {

            $sql = "SELECT 
            co.customer_id AS customer_id,
            c.name AS customer_name,
            co.order_id AS order_id,
            co.message AS message,
            co.image AS image,
            co.status AS status,
            co.id AS complaint_id

            FROM complaints co JOIN
            customer c ON c.id = co.customer_id 
            WHERE co.distributor_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $user_id);

            $stmt->execute();

            $result = $stmt->get_result();

            //When many lines used array
            $complaints = [];

            while($row = $result->fetch_assoc()) {
                $complaints[] = $row;
            }

            return $complaints;

        }

        //Distibutor
        public function resolveComplaint($complaint_id, $reply) {

            $sql = "UPDATE complaints SET
            reply = ?, status = 'resolved'
            WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("si", $reply, $complaint_id);

            return $stmt->execute();


        }
    }