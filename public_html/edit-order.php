<?php


require_once dirname(__FILE__) . '/php/controller/c_order.php';
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("staff")) {
    header('Location: account/login.php');
}
$db = new DbConnection();
$conn = $db->connect();
$order = new Order();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/table.css" />


    <script src="js/Table.js" type="text/javascript"></script>

    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- FONT AWESOME JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <!-- DATE PICKER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- BOOTSTRAP CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        td:nth-child(9) {
min-width: 140px!important;
        }
        td:nth-child(3) {
min-width: 140px!important;
        }
    </style>
    <link rel="stylesheet" href="css/notification.css">
</head>

<body>

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

    <!-- modal to claim order -->
    <div id="qr_modal" class="modal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fw-bold h6">Claim</div>
                </div>
                <div class="modal-body">
                    <!-- order to claim will be appended here -->
                    <div>
                        <div class="h6 fw-bold">Information</div>
                        <input type="hidden" value="" id="to_claim_order_id">
                        <input type="hidden" value="" id="to_claim_type">
                        <div class="qr_to_claim_info" id="qr_to_claim_info"></div>
                    </div>
                    <div>
                        <div class="h6 fw-bold mt-4">Order</div>
                        <div class="qr_to_claim_order d-flex row mb-5 mx-1 justify-content-start"
                            id="qr_to_claim_order"></div>
                    </div>
                    <div>
                        <div class="h6 fw-bold mt-4">SUBTOTAL</div>
                        <div class="qr_to_claim_price" id="qr_to_claim_price"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="qr_confirm" id="qr_confirm"
                        class="btn btn-success w-25">Confirm</button>
                    <button type="button" name="qr_close" id="qr_close" class="btn btn-danger w-25"
                        onclick="new Order().qr_close_modal();">Cancel</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container my-5">

        <span id="success_message"></span>

        <div class="card">

            <div class="card-header ">
                <h3 class="text-center">Order</h3>

            </div>




            <div class="card-body">

                <!-- QR scanner -->

                <button id="toggle_camera" onclick="new Order().toggle_camera();"
                    class="btn btn-toggle btn-success w-100"><i class="fa-solid fa-camera"></i></button>
                <video class="w-100" src="" id="preview"></video>

                <table id="order_table" class="table table-sm ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>order</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $order->fetch_top_five_data(); ?>
                    </tbody>
                </table>


            </div>


        </div>
    </div>



    <!-- modal to edit an order -->
    <div class="modal fade" id="order_modal">
        <form method="post" id="order_form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">

                        <div class="modal-title" id="modal_title">Edit</div>


                    </div>


                    <div class="modal-body">



                        <input type="hidden" name="order_id" id="order_id" />


                        <div class="form-group mt-2">
                            <label class="form-label" for="customer_name">customer_name</label>
                            <input type="text" class="form-control" name="customer_name" id="customer_name" />
                            <span id="customer_name_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="order_name">order_name</label>
                            <input type="text" class="form-control" name="order_name" id="order_name" />
                            <span id="order_name_error"></span>
                        </div>

                        
                        <div class="form-group mt-2">
                            <label class="form-label" for="contact">contact</label>
                            <input type="text" class="form-control" name="contact" id="contact" />
                            <span id="contact_error"></span>
                        </div>


                        <div class="form-group mt-2">
                            <label class="form-label" for="price">price</label>
                            <input type="text" class="form-control" name="price" id="price" />
                            <span id="price_error"></span>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-label" for="quantity">quantity</label>
                            <input type="text" class="form-control" name="quantity" id="quantity" />
                            <span id="quantity_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="date">date</label>
                            <input type="date" class="form-control" name="date" id="date" />
                            <span id="date_error"></span>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-label" for="time">time</label>
                            <input type="time" class="form-control" name="time" id="time" />
                            <span id="time_error"></span>
                        </div>


                        <div class="form-group mt-2">
                            <label class="form-label" for="status">time</label>
                            <select name="status" id="status" class="form-select">
                                <option value="select" disabled>select</option>
                                <option value="Placed">Placed</option>
                                <option value="Preparing">Preparing</option>
                                <option value="Ready">Ready</option>
                            </select>
                            <span id="status_error"></span>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <input type="hidden" name="action_order" id="action_order" value="Add" />
                        <button type="button" class="btn btn-danger w-25 " id="close_modal">Close</i></button>
                        <button type="button" class="btn  btn-success btn-add w-25" id="action_order_button"
                            value="Add">Add</button>
                    </div>


                </div>
            </div>
        </form>
    </div>







    <!-- modal to delete an order -->








    <div id="del_notif_modal" class="modal ">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="modal-title" id="modal_title">Delete</div>
                </div>


                <div class="modal-body">
                    <form method="post" id="del_notif_form">
                        <input type="text" name="order_id" id="del_notif_order_id" />
                        <input type="text" name="user_id" id="del_notif_user_id" />


                       
                        <div>
                            <div class="h6 fw-bold">Information</div>
                            <div class="to_delete_info" id="to_delete_info"></div>
                        </div>
                        <div>
                            <div class="h6 fw-bold mt-4">Order</div>
                            <div class="to_delete_order d-flex row mb-5 mx-1 justify-content-start"
                                id="to_delete_order"></div>
                        </div>
                       

                        <label for="del_notif">Reason</label>
                        <input list="del_list" name="del_notif" id="del_notif" class="form-control" />
                        <datalist id="del_list">
                            <option>Item Unvailable</option>
                        </datalist>
                        <span id="del_notif_error"></span>
                    </form>



                </div>
                <div class="modal-footer">
                    <button type="button" id="del_notif_button" class="btn btn-success w-25">Delete</button>
                    <button type="button" id="close_del_notif" class="btn btn-danger w-25"
                        onclick="new Order().close_del_notif();">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show" id="modal_backdrop"></div>


</body>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript" src="js/instascan.min.js"></script>
<script type="text/javascript" src="js/Order.js"></script>
<script src="js/Notification.js"></script>
<script>
    let order = new Order();

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });
    /* returns the QR code scanned by the  scanner */
    scanner.addListener('scan', function (content) {
        console.log(content);
        order.order_fetch_info(content, "qr");
    });


    /* gets device camera */
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);

        } else {
            console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });

    document.getElementById("qr_confirm").onclick = function () {
        console.log("dsad");
        order.qr_claim_order();
    };

    order.close_del_notif();





    document.getElementById("del_notif_button").onclick = function () {
        order.delete_data();
    };

    /* instantiate JSTable class */
    let table = new JSTable("#order_table", {
        serverSide: true,
        deferLoading: <?php echo $order->count_all_data();?> ,
        ajax : "php/controller/f_order.php"
    });



    order = new Order(table);
    order.close_modal();

    /*    document.getElementById('add_data').onclick = function () {
           order.open_modal();
           order.reset_input();
       }
    */
    document.getElementById('close_modal').onclick = function () {
        order.close_modal();
    }

    document.getElementById('action_order_button').onclick = function () {
        order.add_button = true;
        order.action_order_button();
    }










 /* determined if a customer canceled its order, 
    if an order has been canceled, the table will be reloaded */
    get_notification();
function get_notification() {
    Pusher.logToConsole = true;
    
    let pusher = new Pusher('56c2bebb33825a275ca8', {
        cluster: 'ap1'
    });

    let channel = pusher.subscribe('snackwise');
    channel.bind('notif', function (data) {
      

        if(data['notification']['type'] == "order_customer_to_staff") {
            new Notification().create_notification("A customer canceled an order", "neutral");
            table.update();
            dataRemoved();
        }
     
    });
}
    /*  */



</script>

</html>