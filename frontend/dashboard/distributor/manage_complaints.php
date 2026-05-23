<?php

    session_start();
    if(
        !isset($_SESSION['user_id']) ||
        $_SESSION['role'] !== "distributor"
    ) {
        header("Location: /Aqua-Jar/frontend/auth/login.html");
        exit;
    }

?>

<!doctype html>
<html>
  <head>
    <title>Manage Complaints</title>
    <link rel="stylesheet" href="distributorDashboard.css" />
  </head>

  <body>
    <div class="wrapper">
      <div class="sidebar">
        <div class="logo">
          <h1>JAR</h1>
          <p>Distributor Panel</p>
        </div>

        <div class="menu-title">MAIN MENU</div>

        <a href="dashboard.php">Dashboard</a>
        <a href="manage_jars.php">Manage Jars</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="manage_complaints.php" class="active">Manage Complaints</a>
        <a href="#" onclick="logout(); return false;" class="logout">Logout</a>
      </div>

      <div class="main">
        <div class="page-header">
          <h2>Manage Complaints</h2>
          <p>Resolve customer issues quickly</p>
        </div>

        <div class="panel">
          <div class="panel-title">Complaints</div>
          <p id="complaintsDistributor-message" class="form-message"></p>
       
          <div class="modern-table">

          <table>
            <thead>
                <tr>
                <th>Customer</th>
                <th>Order ID</th>
                <th>Message</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody id="complaintsTable">
            </tbody>
          </table>
          

          <form id="resolveForm" class="modal-form" style="display:none">
            <h3>Resolve Complaint</h3>

            <div class="form-box">
              <textarea 
                id="reply" 
                name="reply" 
                placeholder="Type your reply here..." 
                required
              ></textarea>
            </div>

            <p id="resolve-message" class="form-message"></p>
            
            <div class="form-actions">
              <button type="submit" class="btn-success">Resolve</button>
              <button type="button" class="btn-cancel" onclick="document.getElementById('resolveForm').style.display='none'">Cancel</button>
            </div>
          </form>
          </div>
        </div>
    </div>
    <script src="manage_complaints.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
