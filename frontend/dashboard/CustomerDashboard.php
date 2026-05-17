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

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>customerDashboard</title>
    </head>
    <body>
        <!-- ?= means ?php echo -->
        <p>Welcome <?= $_SESSION['name'] ?>! </p>

        <form id="form">
            name:
            <input type="text" id="name" name="name" disabled/>
            address:
            <input type="text" id="address" name="address" disabled/>
            phone:
            <input type="text" id="phone" name="phone" disabled/>
            email:
            <input type="email" id="email" name="email" disabled/>

            <p id="form-message" class="form-message"></p>
            <button id="editbtn" type="button">Edit Profile</button>
            <button id="savebtn" type="submit" style="display: none;">Save</button>

        </form>

        <h2>Available Jars</h2>

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
        <tbody id="jarTable">
     </tbody>
        </table>
            <p id="jar-message" class="form-message"></p>


        <form id="orderForm" style="display:none;">
            <input type="hidden" id="distributor_id" name="distributor_id">

            Quantity:
            <input type="number" id="quantity" name="quantity">

            Delivery Date & Time:
            <input type="datetime-local"
                id="delivery_datetime"
                name="delivery_datetime">

            Location:
            <input type="text"
                id="location"
                name="location">

            <button type="submit">Place Order</button>

            <p id="order-message" class="form-message"></p>
    
        </form>
        <script src="customerDashboard.js"></script>
    </body>
    </html>

