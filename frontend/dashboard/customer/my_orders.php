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
        <h1>JAR</h1>
        <p>💧 Aqua Jar - Customer Panel</p>
      </div>

      <div class="menu-title">MAIN MENU</div>

      <a href="dashboard.php">
        <span class="icon">🏠</span> >Dashboard</a
      >
      <a href="my_orders.php" class="active"> <span class="icon">📦</span>My Orders</a>
      <a href="order_history.php"> <span class="icon">📦</span>Order History</a>
      <a href="manage_complaints.php">
        <span class="icon">🕓</span>Manage Complaints</a
      >
      <a
        href="#"
        onclick="
          logout();
          return false;
        "
        class="logout"
        >Logout</a
      >
    </div>

    <!-- ═══ MAIN CONTENT ═══════════════════════════════════════════════════ -->
    <div class="main-content">
      <!-- TOPBAR -->
      <div class="topbar">
        <h1 id="welcome-msg">Welcome 👋</h1>
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
            <h2>My Active Orders</h2>
            <p id="myOrder-message" class="form-message"></p>
            <div id="active-area">
                <table>
                    <thead>
                        <tr>
                        <th>Distributor</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Total Price</th>
                        <th>Order Status</th>
                        <th>Driver Name</th>
                        <th>Driver Contact</th>
                        </tr>
                    </thead>
                    <tbody id="myOrderTable">
                    </tbody>
                </table>
                        
            </div>
            </div>
        </div>
    </div>
    
    <script src="my_orders.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>