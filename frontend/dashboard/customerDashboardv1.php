<!-- <?php
    // session_start();
    // if(
    //     !isset($_SESSION['user_id']) ||
    //     $_SESSION['role'] !== "customer"
    // ) {
    //     header("Location: /Aqua-Jar/frontend/auth/login.html");
    //     exit;
    // }
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQua — My Dashboard</title>
    <link rel="stylesheet" href="customerDashboard.css">
</head>
<body>

    <!-- ===== HEADER ===== -->
    <div class="hdr">
        <div class="hdr-left">
            <div class="hdr-drop">💧</div>
            <div>
                <div class="hdr-brand">AQua Water Service</div>
                <div class="hdr-sub">जल सुरक्षा — Safe Water, Every Day</div>
            </div>
        </div>
        <div class="hdr-right">
            <div class="hdr-welcome">Welcome, <?= $_SESSION['name'] ?>!</div>
            <a href="/Aqua-Jar/frontend/auth/logout.php" class="btn-logout">🔓 Logout</a>
        </div>
    </div>

    <!-- ===== MAIN BODY ===== -->
    <div class="body">

        <!-- Help Notice -->
        <div class="notice">
            <span class="notice-icon">ℹ️</span>
            <span>Need help? Call us at <strong>01-XXXXXXX</strong> — we are happy to assist you with your water order.</span>
        </div>

        <!-- ===== PROFILE SECTION ===== -->
        <div class="section">
            <div class="sec-title">👤 My Profile</div>

            <div class="tip-box">
                <span class="tip-icon">💡</span>
                <span>Click <strong>Edit Profile</strong> to update your details. Then click <strong>Save Changes</strong> when done.</span>
            </div>

            <div class="profile-card">
                <form id="form">
                    <div class="form-grid">
                        <div class="field">
                            <label class="flabel" for="name">Full Name</label>
                            <input class="finput dis" type="text" id="name" name="name" disabled />
                        </div>
                        <div class="field">
                            <label class="flabel" for="address">Home Address</label>
                            <input class="finput dis" type="text" id="address" name="address" disabled />
                        </div>
                        <div class="field">
                            <label class="flabel" for="phone">Phone Number</label>
                            <input class="finput dis" type="text" id="phone" name="phone" disabled />
                        </div>
                        <div class="field">
                            <label class="flabel" for="email">Email Address</label>
                            <input class="finput dis" type="email" id="email" name="email" disabled />
                        </div>
                    </div>

                    <p id="form-message" class="form-message"></p>

                    <div class="form-btns">
                        <button id="editbtn" type="button">✏️ Edit Profile</button>
                        <button id="savebtn" type="submit" style="display:none;">💾 Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== AVAILABLE JARS ===== -->
        <div class="section">
            <div class="sec-title">🪣 Available Water Jars</div>

            <div class="tip-box">
                <span class="tip-icon">💡</span>
                <span>Click the <strong>Order →</strong> button on the right to order a water jar from that station.</span>
            </div>

            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Water Station</th>
                            <th>Price</th>
                            <th>Jar Size</th>
                            <th>In Stock</th>
                            <th>Delivery Area</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="jarTable">
                        <!-- Filled by customerDashboard.js -->
                    </tbody>
                </table>
            </div>
            <p id="jar-message" class="form-message"></p>
        </div>

        <!-- ===== ORDER FORM ===== -->
        <div class="section" id="orderFormSection" style="display:none;">
            <div class="sec-title">🛒 Place Your Order</div>

            <div class="order-card">
                <p class="order-dist-label">
                    Ordering from: <strong id="dist-name-label"></strong>
                </p>

                <form id="orderForm">
                    <input type="hidden" id="distributor_id" name="distributor_id">

                    <div class="order-grid">
                        <div class="field">
                            <label class="flabel" for="quantity">How Many Jars?</label>
                            <input class="finput active" type="number" id="quantity" name="quantity" min="1" placeholder="Example: 2" />
                        </div>
                        <div class="field">
                            <label class="flabel" for="delivery_datetime">Delivery Date &amp; Time</label>
                            <input class="finput active" type="datetime-local" id="delivery_datetime" name="delivery_datetime" />
                        </div>
                        <div class="field full-width">
                            <label class="flabel" for="location">Your Delivery Address</label>
                            <input class="finput active" type="text" id="location" name="location" placeholder="Type your full address here..." />
                        </div>
                    </div>

                    <p id="order-message" class="form-message"></p>

                    <button type="submit" class="btn-place">🚚 Confirm &amp; Place Order</button>
                    <button type="button" class="btn-cancel" id="cancelOrderBtn">✖ Cancel</button>
                </form>
            </div>
        </div>

        <!-- ===== MY ORDERS ===== -->
        <div class="section">
            <div class="sec-title">📦 My Orders</div>

            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Water Station</th>
                            <th>Jars Ordered</th>
                            <th>Order Status</th>
                            <th>Driver Name</th>
                            <th>Driver Phone</th>
                        </tr>
                    </thead>
                    <tbody id="myOrderTable">
                        <!-- Filled by customerDashboard.js -->
                    </tbody>
                </table>
            </div>
            <p id="myOrder-message" class="form-message"></p>
        </div>

    </div><!-- end .body -->

    <!-- ===== FOOTER ===== -->
    <div class="ftr">
        💧 AQua Water Service &nbsp;|&nbsp; Call us: <strong>01-XXXXXXX</strong> &nbsp;|&nbsp; जल सुरक्षा — Safe Water for Every Family
    </div>

    <script src="customerDashboard.js"></script>

</body>
</html>
