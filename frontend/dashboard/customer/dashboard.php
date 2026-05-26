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
          <li><a href="dashboard.php" class="active">
            <span class="icon">🏠</span> Dashboard</a></li>
          <li><a href="my_orders.php"> <span class="icon">📦</span>My Orders</a></li>
          <li><a href="order_history.php"> <span class="icon">📦</span>Order History</a></li>
          <li><a href="complaint_status.php">
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
      <div class="page-section active" id="page-dashboard">
        <p id="stats-message" class="form-message"></p>
        <div class="cards">
          <div class="card">
            <h3>Total Orders</h3>
            <p id="stat-total"></p>
          </div>
          <div class="card">
            <h3>Arriving</h3>
            <p id="stat-arriving"></p>
          </div>
          <div class="card">
            <h3>Delivered</h3>
            <p id="stat-delivered"></p>
          </div>
          <div class="card">
            <h3>Open Complaints</h3>
            <p id="stat-complaints"></p>
          </div>
        </div>

        <!-- Available Jars -->
        <div class="table-wrap">
          <h2>Available Jars to Order</h2>
          <div id="jars-area">
            <table border="1" width="100%">
              <thead>
                <tr>
                  <th>Distributor</th>
                  <th>Price</th>
                  <th>Unit</th>
                  <th>Stock</th>
                  <th>Service Area</th>
                  <th>Order</th>
                </tr>
              </thead>
              <tbody id="jarTable"></tbody>
            </table>
            <p id="jar-message" class="form-message"></p>
          </div>
        </div>
        <div class="form-group">
            <form id="orderForm" style="display: none">
              <input type="hidden" id="distributor_id" name="distributor_id" />
              <input type="hidden" id="jar_id" name="jar_id" />
              Quantity:
              <input type="number" id="quantity" name="quantity" />
              <small class="error-msg"></small>

              Delivery Date & Time:
              <input
                type="datetime-local"
                id="delivery_datetime"
                name="delivery_datetime"
              />
              <small class="error-msg"></small>

              Location:
              <input type="text" id="location" name="location" />
              <small class="error-msg"></small>

              <button type="submit">Place Order</button>

              <p id="order-message" class="form-message"></p>
            </form>
        </div>
        
      </div>
    
    <script src="dashboard.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
