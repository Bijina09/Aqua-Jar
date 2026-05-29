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
                <div class="panel-title">User Profile</div>
                <p id="profile-message" class="form-message"></p>

                <form id="form-box">
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
                    <label for="serviceArea">Service Area:</label>
                    <input type="text" id="serviceArea" name="serviceArea" disabled/>
                    <small class="error-msg"></small>
                    </div>
                    
                    <div class="form-group">
                    <label for="panNo">PAN NO:</label>
                    <input type="text" id="panNo" name="panNo" readonly/>
                    <small class="error-msg"></small>
                    </div>
                    <div class="form-group">
                    <label for="supplierName">Supplier Name:</label>
                    <input type="text" id="supplierName" name="supplierName" disabled/>
                    <small class="error-msg"></small>
                    </div>
                    <div class="form-group">
                    <label for="supplierPanNo">Supplier PAN No:</label>
                    <input type="text" id="supplierPanNo" name="supplierPanNo" readonly/>
                    <small class="error-msg"></small>
                    </div>

                    <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" readonly/>
                    <small class="error-msg"></small>
                    </div>

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