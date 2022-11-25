<?php
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("customer")) {
    header('Location: account/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Snackwise</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>


    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/notification.css">



    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>



</head>

<body>

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

    <div class="details-modal" id="order_details_list">
        
    </div>

    <div class="parent-container">
        <!-- START OF NAVBAR -->
        <nav class="navbar navbar-light bg-light navbar-expand-md">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <!-- <img src="./img/penguin.png" alt="Penguin Logo" height="58" width="52"> -->
                    <span class="red">SNACK</span><span class="yellow">WISE</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto nav-list">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link" id="">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <?php
                    if ($validate->is_logged_in("customer")) {
                    ?>
                        <form action="#" class="form-inline sign-btns">
                            <a name="log-in-btn" class="btn" href="account/login.php">Login</a>
                            <a name="sign-up-btn" id="" class="btn btn-primary" href="account/register.php" role="button">Sign Up</a>
                        </form>
                    <?php
                    } else {

                    ?>
                        <div class="user-dropdown-container">
                            <button class="user-button">
                                <i class="fa-solid fa-circle-user"></i>
                            </button>
                            <ul class="drop-menu">
                                <li><a href="order.php" class="drop-item" id="active">My Orders <i class="fa-solid fa-receipt"></i></a></li>
                                <li><a href="account/logout.php" class="drop-item">Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
                            </ul>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
        </nav>
        <!-- ENG OF NAVBAR -->

        <div class="order-container">
            <div class="order-header">
                <h1>My Orders</h1>
            </div>
            <div class="order-sort-container">
                <ul class="sort-list">
                    <li class="sort-item" id="active-sort">
                        <input type="radio" name="category" value="All" id="category1" checked>
                        <label for="category1">All</label>
                    </li>
                    <li class="sort-item" id="">
                        <input type="radio" name="category" value="Placed" id="category2"> 
                        <label for="category2">Pending</label>
                    </li>
                    <li class="sort-item">
                        <input type="radio" name="category" value="Preparing" id="category3">
                        <label for="category3">Preparing</label>
                    </li>
                    <li class="sort-item">
                        <input type="radio" name="category" value="Ready" id="category4">
                        <label for="category4">To Pickup</label>
                    </li>
                    <li class="sort-item">
                        <input type="radio" name="category" value="Cancelled" id="category6">
                        <label for="category6">Cancelled</label>
                    </li>
                    <li class="sort-item">
                        <input type="radio" name="category" value="Completed" id="category5">
                        <label for="category5">Completed</label>
                    </li>
                </ul>
            </div>

     
            <!-- ORDERS TO BE APPENDED HERE -->
            <div class="order-list" id="order_list"> </div>
           
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/Order.js"></script>
<script src="js/Notification.js"></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js'></script>
<script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/video/lg-video.umd.js'></script>
    <script>
        /* DROPDOWN */

        const dropMenu = document.querySelector('.drop-menu');
        const dropBtn = document.querySelector('.user-button');
        let dropOpen = false;

        if (dropBtn) {
            dropBtn.addEventListener("click", () => {
                if (!dropOpen) {
                    dropMenu.style.display = "block";
                    dropOpen = true;
                } else {
                    dropOpen = false;
                    dropMenu.style.display = "none";
                }

            })
        }

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
</body>

</html>