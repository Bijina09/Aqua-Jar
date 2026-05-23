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
    <title>Manage Jars</title>
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

        <a href="dashboard.php">Dashboard</a>
        <a href="manage_jars.php" class="active">Manage Jars</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="manage_complaints.php">Manage Complaints</a>
        <a href="#" onclick="logout(); return false;" class="logout">Logout</a>
      </div>

      <!-- MAIN -->
      <div class="main">
        <div class="page-header">
          <h2>Manage Jars</h2>
          <p>Inventory control and stock management</p>
        </div>

        <!-- FORM -->
        <div class="panel">
          <form class="form-box" id="postForm">
            <input 
            type="number" 
            id="quantity" 
            name="quantity"
            placeholder="Enter Available Stock"
            required
            />
            <input
              type="text"
              id="price"
              name="price"
              placeholder="Enter Price"
              required
            />
            <input
              type="text"
              id="unit"
              name="unit"
              placeholder="Enter Unit"
              required
            />
            <p id="post-message" class="form-message"></p>
            <button name="add" type="submit">Add Jar</button>
        </div>

        <!-- TABLE -->
        <div class="panel">
          <div class="panel-title">Manage Jars</div>
          <p id="jars-message" class="form-message"></p>


          <div class="modern-table">
            <table>
            <thead>
              <tr>
                <th>Quantity</th>
                <th>Price</th>
                <th>Unit</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="jarDetailsTable">
            </tbody> 
            </table>
        </div>
      </div>
    </div>
    <script src="manage_jars.js"></script>
    <script src="../shared/utils.js"></script>
  </body>
</html>
