<!-- Make bill here -->
 <!-- AQUA JAR WATER SUPPLY SYSTEM
DIGITAL INVOICE

Invoice No: INV-0012
Order Date: 26 May 2026
Status: Delivered

Customer: Bijina Khatri
Delivery Location: Iplex Mall, Baneshwor
Delivery Time: 28 May 2026, 6:28 PM

Distributor: Shishir Ghimire
Distributor Location: Baneshwor

------------------------------------------------

Item: Aqua Jar
Package Type: Per 3 Jars
Price Per Pack: Rs.80
Packs Ordered: 3
Total Jars: 9
Total Price: Rs.240   This should be in line .......

------------------------------------------------

Grand Total: Rs.240

Thank you for choosing Aqua Jar
This invoice is system generated

Like this -->

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
  <body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
          <h1>Aqua Jar</h1>
          <p>Customer Panel</p>
        </div>
        <ul class="sidebar-menu">
          <li>
            <a href="dashboard.php" class="active">
              <span class="icon">🏠</span> Dashboard
            </a>
          </li>
          <li>
            <a href="my_orders.php">
              <span class="icon">📦</span>My Orders
            </a>
          </li>
          <li>
            <a href="order_history.php">
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
        <div class="sidebar-bottom" class="active">

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

        <!-- ══ Profile ══════════════════════════════════════════════════════ -->
        <div class="page-section active" id="page-settings">
            <div class="panel">
            <h2>User Profile</h2>
            <div class="profile-grid" style="margin-bottom:20px;">
            <form id="profileForm">
            <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" disabled/>
            <small class="error-msg"></small>
            </div>
            
            <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" disabled/>
            <small class="error-msg"></small>
            </div>

            <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" disabled/>
            <small class="error-msg"></small>
            </div>

            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" disabled/>
            <small class="error-msg"></small>
            </div>

            <p id="profile-message" class="form-message"></p>
            <div class="btn-group">
            <button id="editbtn" type="button">Edit Profile</button>
            <button id="savebtn" type="submit" style="display: none;">Save</button>
</div>

        </form>
            </div>
            </div>
        </div>
    
    <script src="profile.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
