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

<!DOCTYPE html>
    <html>
    <head>
        <title>Manage Orders</title>
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
            <a href="manage_jars.php">Manage Jars</a>
            <a href="manage_orders.php" class="active">Manage Orders</a>
            <a href="manage_complaints.php">Manage Complaints</a>
            <a href="profile.php">Profile</a>
            <a href="#" onclick="logout(); return false;" class="logout">Logout</a>

        </div>

        <!-- MAIN -->
        <div class="main">

            <div class="page-header">
                <h2>Manage Orders</h2>
                <p>Update order status manually and track deliveries</p>
            </div>

            <div class="panel">
                <div class="panel-title">Available Orders</div>
                <p id="order-message" class="form-message"></p>

                <div class="modern-table">
                    <table>
                    <thead>
                        <tr>
                        <th>Customer</th>
                        <th>Packs Ordered</th>
                        <th>Location</th>
                        <th>Delivery Date and Time</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <script src="manage_orders.js"></script>
    <script src="../shared/utils.js"></script>
    </body>
</html>