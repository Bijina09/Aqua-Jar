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
    <title>Distributor Dashboard</title>
    <link rel="stylesheet" href="distributorDashboard.css" />
  </head>

  <body>
    <div class="wrapper">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <div class="logo">
          <h1>JAR</h1>
          <p>Distributor Panel</p>
        </div>

        <div class="menu-title">MAIN MENU</div>

        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="manage_jars.php">Manage Jars</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="manage_complaints.php">Manage Complaints</a>
        <a href="profile.php">Profile</a>
        <a href="#" onclick="logout(); return false;" class="logout">Logout</a>
      </div>

      <!-- MAIN -->
      <div class="main">
        <p id="logout-message" class="form-message"></p>
        <!-- HEADER -->
        <div class="dashboard-header">
          <div>
            <h1 class="title">Distributor Dashboard</h1>
            <p class="subtitle">Live operational overview</p>
          </div>

          <div class="date-box"><?php echo date("l, d M Y"); ?></div>
          <button
            class="theme-btn"
            id="theme-toggle-btn"
            onclick="toggleTheme()"
            title="Toggle dark/light mode"
          >
            🌙
          </button>
        </div>

        <!-- STATS -->
        <p id="stats-message" class="form-message"></p>
        <div class="stats-grid">
          <div class="metric-card blue">
            <div class="metric-label">Total Orders</div>
            <div class="metric-value" id="total-orders"></div>
            <div class="metric-note">All received orders</div>
          </div>

          <div class="metric-card yellow">
            <div class="metric-label">Pending Orders</div>
            <div class="metric-value" id="pending-orders"></div>
            <div class="metric-note">Pending orders</div>
          </div>

          <div class="metric-card green">
            <div class="metric-label">Total Jars</div>
            <div class="metric-value" id="total-jars"></div>
            <div class="metric-note">Inventory stock</div>
          </div>

          <div class="metric-card red">
            <div class="metric-label">Complaints</div>
            <div class="metric-value" id="open-complaints"></div>
            <div class="metric-note">Pending issues</div>
          </div>
        </div>

        <!-- ACTIVITY -->
        <div class="panel">
          <div class="panel-title">Recent Distributor Activity</div>
          <p id="recent-message" class="form-message"></p>
          <div class="activity-feed" id="activityFeed">
            <!-- Populated by JS -->
          </div>
        </div>

      </div>
    </div>
    <script src="dashboard.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
