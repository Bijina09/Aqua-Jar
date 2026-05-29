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
        <ul class="sidebar-menu">
          <li>
            <a href="dashboard.php">
              <span class="icon">🏠</span> Dashboard
            </a>
          </li>
          <li>
            <a href="my_orders.php">
              <span class="icon">📦</span>My Orders
            </a>
          </li>
          <li>
            <a href="order_history.php" class="active">
              <span class="icon">📦</span>Order History
            </a>
          </li>
          <li>
            <a href="complaint_status.php">
              <span class="icon">🕓</span>Complaint Status
            </a>
          </li>
        </ul>

         <!-- Bottom section -->
        <div class="sidebar-bottom">

          <a href="profile.php">
            <span class="icon">👤</span> Profile
          </a>

          <a
            href="#"
            onclick="
              logout();
              return false;
            "
            class="logout"
            ><span class="icon">🚪</span> Logout
          </a>
        </div>
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
            <h2>Order History</h2>
            <p id="orderHistory-message" class="form-message"></p>
            <div id="active-area">
                <table>
                    <thead>
                        <tr>
                        <th>Distributor</th>
                        <th>Packs Ordered</th>
                        <th>Price per Pack</th>
                        <th>Package Type</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Billing</th>
                        <th>Complaint</th>
                        </tr>
                    </thead>
                    <tbody id="orderHistoryTable">
                    </tbody>
                </table>
                        
            </div>
            </div>
              <div class="form-wrapper">
                <form id="complaintForm" style="display:none;" enctype="multipart/form-data">
                    <input type="hidden" id="order_id" name="order_id">
                    
                    <div class="form-group">
                      <label for="message">Message:</label>
                      <textarea id="message" name="message" row="4" cols="50" placeholder="Type your complaint here..."></textarea>
                      <small class="error-msg"></small>
                    </div>
                    <div class="form-group">
                      <label for="image">Choose a photo:</label>
                      <input type="file" id="image" name="image"
                      accept="image/png, image/jpeg">
                      <small class="error-msg"></small>
                    </div>
                    <button type="submit">Submit Complaint</button>

                    <p id="complaint-message" class="form-message"></p>
            
                </form>     
            </div>
        </div>
    </div>
    
    <script src="order_history.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>