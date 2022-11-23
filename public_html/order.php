<?php
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__).'/php/classes/Validate.php';

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


    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <!-- MY CSS -->
   
    <link rel="stylesheet" href="css/notification.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>
    <style>
        /* light gallery backdrop */
   

    </style>
</head>

<body>
    
    <input type="radio" name="category" value="Placed">Pending
    <input type="radio" name="category" value="Preparing">Preparing
    <input type="radio" name="category" value="Ready">To Pickup
    <input type="radio" name="category" value="Completed">Completed
    <input type="radio" name="category" value="Cancelled">Cancelled
    <!-- orders will be appended here -->
    <div class="order_list" id="order_list"></div>


    <div id="order_details_modal" class="modal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="modal-title h5 fw-bold">CHECKOUT</div>
                </div>
                <div class="modal-body">
                    <div class="mt-2">
                        
<div id="order_details_list"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" name="add_to_order"
                        id="add_to_order">Cancel Order</button>
                    <button class="btn btn-danger" type="button" id="cancel_add_to_order"
                        onclick="new Order().close_order_details();">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>


    
        <div class="modal-backdrop fade show" id="modal_backdrop"></div>
    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>
</body>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

<script src="js/Order.js"></script>
<script src="js/Notification.js"></script>


<script>
     new Order().customer_order();


<?php 
    /* adds selected bestseller item to cart */
        if(isset($_GET['order'])) {
     ?>
    new Notification().create_notification("Order Successfully Placed", "success");
    let url = document.location.href;
    window.history.pushState({}, "", url.split("?")[0]);
<?php
        } 
        ?>
        </script>

</html>