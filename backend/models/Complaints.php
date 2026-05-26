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
            reply = ?, status = 'resolved',
            resolved_at = current_timestamp()
            WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("si", $reply, $complaint_id);

            return $stmt->execute();


        }

        //Distributor Dashboard
        public function getOpenComplaints($distributorId) {

            $sql = "SELECT SUM(id) AS open_complaints
            FROM complaints
            WHERE distributor_id = ? AND status = 'OPEN'";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $distributorId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

        //Customer Dashboard
        public function getCustomerOpenComplaints($customerId) {

            $sql = "SELECT SUM(id) AS open_complaints
            FROM complaints
            WHERE customer_id = ? AND status = 'OPEN'";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $customerId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();

        }

        public function getComplaintStatus($customerId) {

            $sql = "SELECT 
            d.name AS distributor_name,
            c.order_id AS order_id,
            c.message AS message,
            c.image AS image,
            c.reply AS reply,
            c.status AS status,
            c.created_at AS submitted_at,
            c.resolved_at AS resolved_at

            FROM complaints c JOIN
            distributor d ON c.distributor_id = d.id
            WHERE customer_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("i", $customerId);

            //Don't go forgetting this
            $stmt->execute();

            $result = $stmt->get_result();

            //Same task as loop
            return $result->fetch_all(MYSQLI_ASSOC);

        }
    }