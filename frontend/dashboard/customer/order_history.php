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

      <a href="dashboard.php" class="active">
        <span class="icon">🏠</span> >Dashboard</a
      >
      <a href="my_orders.php"> <span class="icon">📦</span>My Orders</a>
      <a href="orders_history.php"> <span class="icon">📦</span>Order History</a>
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
            <h2>Order History</h2>
            <p id="orderHistory-message" class="form-message"></p>
            <div id="active-area">
                <table>
                    <thead>
                        <tr>
                        <th>Distributor</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Driver Name</th>  
                        <th>Complaint</th>
                        </tr>
                    </thead>
                    <tbody id="orderHistoryTable">
                    </tbody>
                </table>
                        
            </div>
            </div>
            <div class="form-group">
                <form id="complaintForm" style="display:none;" enctype="multipart/form-data">
                    <input type="hidden" id="order_id" name="order_id">
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" row="4" cols="50" placeholder="Type your complaint here..."></textarea>

                    <label for="image">Choose a photo:</label>
                    <input type="file" id="image" name="image" accept="image/*">

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