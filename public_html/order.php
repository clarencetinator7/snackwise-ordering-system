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
    <link rel="stylesheet" href="css/notification.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>
<style>
    /* light gallery backdrop */
    .lg-backdrop{
    opacity:0.8 !important;
}
</style>
</head>

    <button type="button" id="current_order">Ordes</button>


   <button type="button" id="completed_order">Order History</button>


<body>
    <!-- orders will be appended here -->
    <div class="order_list" id="order_list"></div>

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

</body>



<script src="js/Order.js"></script>
<script src="js/Notification.js"></script>

<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/video/lg-video.umd.js'></script>

    <script>


    let order = new Order();
    document.addEventListener("DOMContentLoaded", function (event) {
        order.display_order();
       document.getElementById("current_order").onclick = function() {

           order.display_order();
       };
       document.getElementById("completed_order").onclick = function() {

           order.display_completed_order();
        };
        
    });
    
    
    
   


</script>
<?php 
    /* adds selected bestseller item to cart */
        if(isset($_GET['s'])) {
     ?>
     <script>
    new Notification().create_notification("Order Successfully Placed", "success");
    let url= document.location.href;
    window.history.pushState({}, "", url.split("?")[0]);
     </script>
     <?php
        } 
        
        ?>
</html>