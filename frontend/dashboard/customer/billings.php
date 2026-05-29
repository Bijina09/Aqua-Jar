<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "customer") {
    header("Location: /Aqua-Jar/frontend/auth/login.html");
    exit;
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aqua Jar – Invoice</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="billings.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
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

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar">
      <h1>Invoice</h1>
      <div class="topbar-actions">
        <button class="theme-btn" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle dark/light mode">🌙</button>
        <button onclick="logout()">Logout</button>
      </div>
    </div>

    <div class="billing-wrap">
      <!-- Toolbar -->
      <div class="billing-toolbar">
        <a href="order_history.php" class="back-link">
          <i class="ti ti-arrow-left"></i> Back to order history
        </a>
        <div class="billing-btns">
          <button class="bill-btn" onclick="window.print()">
            <i class="ti ti-printer"></i> Print
          </button>
          <button class="bill-btn primary" onclick="exportPDF()">
            <i class="ti ti-file-download"></i> Export PDF
          </button>
        </div>
      </div>

      <!-- Invoice card (populated by JS) -->
      <div class="invoice-card" id="invoice-body">
        <div class="state-msg" id="invoice-loading">Loading invoice…</div>
      </div>
    </div>
  </div>

  <!-- Pass PHP variable to JS -->
  <script>window.__ORDER_ID__ = <?= $order_id ?>;</script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script src="../shared/utils.js"></script>
  <script src="billings.js"></script>
</body>
</html>
