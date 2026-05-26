<?php

    session_start();
    if(
        !isset($_SESSION['user_id']) ||
        $_SESSION['role'] !== "customer"
    ) {
        header("Location: /Aqua-Jar/frontend/auth/login.html");
        exit;
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aqua Jar – Customer Dashboard</title>
    <link rel="stylesheet" href="dashboard.css" />
  </head>
  <body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
          <h1>Aqua Jar</h1>
          <p>Customer Panel</p>
        </div>
        <ul>
          <li><a href="dashboard.php">
            <span class="icon">🏠</span> Dashboard</a></li>
          <li><a href="my_orders.php"> <span class="icon">📦</span>My Orders</a></li>
          <li><a href="order_history.php"> <span class="icon">📦</span>Order History</a></li>
          <li><a href="complaint_status.php" class="active">
            <span class="icon">🕓</span>Complaint Status</a
          ></li>
          <li><a
            href="#"
            onclick="
              logout();
              return false;
            "
            class="logout"
            >Logout</a
      ></li>
      </ul>
    

</div>

    <!-- ═══ MAIN CONTENT ═══════════════════════════════════════════════════ -->
    <div class="main-content">
      <!-- TOPBAR -->
      <div class="topbar">
        <h1 id="welcome-msg">Welcome back, <?= $_SESSION['name'] ?>!👋</h1>
        <div class="topbar-actions">
          <button
            class="theme-btn"
            id="theme-toggle-btn"
            onclick="toggleTheme()"
            title="Toggle dark/light mode"
          >
            🌙
          </button>
          <button onclick="logout()">Logout</button>
        </div>
      </div>

      <!-- ══ DASHBOARD PAGE ════════════════════════════════════════════════ -->
      <div class="page-section active" id="page-active-orders">
         <!-- ══ ACTIVE ORDERS ══════════════════════════════════════════════════ -->
            <div class="table-wrap">
            <h2>Complaint Status</h2>
            <p id="complaintStatus-message" class="form-message"></p>
            <div id="active-area">
                <table>
                    <thead>
                        <tr>
                        <th>Distributor</th>
                        <th>Order Id</th>
                        <th>Message Sent</th>
                        <th>Image</th>
                        <th>Reply</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Resolved At</th>
                        </tr>
                    </thead>
                    <tbody id="complaintStatusTable">
                    </tbody>
                </table>
                        
            </div>
            </div>
        </div>
    </div>
    
    <script src="complaint_status.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
