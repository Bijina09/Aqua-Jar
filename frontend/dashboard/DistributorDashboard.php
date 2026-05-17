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
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DistributorDashboard</title>
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
            panNo:
            <input type="text" id="panNo" name="panNo" disabled/> <br>
            supplier name:
            <input type="text" id="supplierName" name="supplierName" disabled/>
            supplier PanNo:
            <input type="text" id="supplierPanNo" name="supplierPanNo" disabled/>
            email:
            <input type="email" id="email" name="email" disabled/>

            <p id="form-message" class="form-message"></p>
            <button id="editbtn" type="button">Edit Profile</button>
            <button id="savebtn" type="submit" style="display: none;">Save</button>

        </form>

        <form id="postForm">
            Available stock:
            <input type="text" id="quantity" name="quantity" />
            price:
            <input type="text" id="price" name="price" />
            unit:
            <input type="text" id="unit" name="unit" /> <br>


            <p id="post-message" class="form-message"></p>
            <button type="submit">Post</button>

        </form>

        <script src="distributorDashboard.js"></script>
    </body>
    </html>

