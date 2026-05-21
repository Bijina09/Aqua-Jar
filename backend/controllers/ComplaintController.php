<?php
    require_once __DIR__ . "/../models/Complaints.php";
    require_once __DIR__ . "/../config/db.php";

    header("Content-Type: application/json");
    
    class ComplaintController{

        //Helper function
        private function clean($key) {
            //null coalescing operator(empty if does not exist so No JSON Breaking)
            return trim($_POST[$key] ?? "");
        }
        
        //For repeated JSON messages
        private function response($status, $message) {
            echo json_encode([
                    "status" => $status,
                    "message" => $message
                ]);
            exit;
        }

        //Customer Side
        public function raiseComplaint() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Same comment check customer
            if(!isset($_SESSION['user_id']) ||
                $_SESSION['role'] !== "customer"
            ) {
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $complaint = new Complaints($conn);
            
            //Cleaning $_POST
            $order_id = $this->clean("order_id");
            $message = $this->clean("message");
            $image = $_FILES['image'];

            //Safe input check
            if (
                empty($order_id) ||
                empty($message)
            ) {
               $this->response("error", "OrderId and Message is required");
            }

            $imagePath = null;

            //File exists and upload is valid
            //0-success, 1-file too large, 4-no file uploaded
            if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                
                $allowed = ['image/jpeg','image/png','image/jpg'];

                if (!in_array($_FILES['image']['type'], $allowed)) {
                    return $this->response("error", "Invalid image type");
                }

                //backend/uploads
                $targetDir = __DIR__ . "/../uploads/";

                //Generating unique filename, prevents overwrite
                $fileName = time() . "_" . basename($image["name"]);

                //Full server path for PHP file handling
                $targetFile = $targetDir . $fileName;

                //Copies from PHP temp storage into the uploads folder
                move_uploaded_file($image["tmp_name"], $targetFile);

                //Relative path (Becomes src) Used for browser display
                $imagePath = "/Aqua-Jar/backend/uploads/" . $fileName;
            }

            $result = $complaint->raiseComplaint($order_id,
            $message,
            $imagePath);

            if(!$result) {
                $this->response("error", "Complaint submission failed");
            }

            $this->response("success", "Complaint submitted successfully");

        }

        //Distibutor Side
        public function viewComplaints() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Same comment check customer
            if(!isset($_SESSION['user_id']) ||
                $_SESSION['role'] !== "distributor"
            ) {
                $this->response("error", "Unauthorized");

            }

            $user_id = $_SESSION['user_id'];

            $complaint = new Complaints($conn);

            $result = $complaint->viewComplaints($user_id);

            if(empty($result)) {
                $this->response("error", "Complaints loading failed");
            }

           echo json_encode([
            "status" => "success",
            "data" => $result 
           ]);

        }

         //Distibutor Side
        public function resolveComplaint() {

            global $conn;
           
            session_start();

            //If no user_id error so check
            //Same comment check customer
            if(!isset($_SESSION['user_id']) ||
                $_SESSION['role'] !== "distributor"
            ) {
                $this->response("error", "Unauthorized");

            }

            $data = json_decode(file_get_contents("php://input"), true);
            $complaint_id = $data['complaint_id'];
            $reply = $data['reply'];

            $complaint = new Complaints($conn);

            $result = $complaint->resolveComplaint($complaint_id, $reply);

            if(empty($result)) {
                $this->response("error", "Complaint resolving failed");
            }

          $this->response("success", "Complaint resolved successfully");

        }
    }
?>