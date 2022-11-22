<?php 
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__).'/php/classes/Validate.php';

$_SESSION['password'] = 1;
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];
$validate=new Validate();
if($validate->is_logged_in("customer")){
     header('Location: account/login.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/notification.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <style>
        input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {  
   opacity: 1;
}
    </style>
</head>

<body>
     <!-- customers added to cart items will be appended here -->
    <div class="cart_list" id="cart_list"></div>

    <div id="order_modal">
        <!-- customers to checkout items will be appended here -->
        <div class="verify_list" id="verify_list"></div>
        <form id="order_form" method="POST">
            <input type="text" id="cartlist" name="cartlist" placeholder="cartlist">
            <input type="text" id="time" name="time">
            <input type="date" id="date" name="date">
            <button type="button" name="add_to_order" id="add_to_order">Order</button>
            <button type="button" id="cancel_add_to_order" onclick="new Cart().cancel_order();">Cancel</button>
        </form>
    </div>


    <div> Total Price</div>
    <!-- total price will be shown here -->
    <div id="cart_total_price">0 </div>
    <button type="button" id="verify_order">Order</button>
    
     <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

</body>

<script src="js/Cart.js"></script>
<script src="js/Notification.js"></script>

<script>
    
    document.addEventListener("DOMContentLoaded", function (event) {
        
        let cart = new Cart();
        cart.cart();
    
    });
    
</script>

</html>