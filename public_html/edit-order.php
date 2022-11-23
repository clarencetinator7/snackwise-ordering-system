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
                        class="btn btn-success w-25" onclick=" new Order().claim_order();">Confirm</button>
                    <button type="button" name="qr_close" id="qr_close" class="btn btn-danger w-25"
                        onclick="new Order().qr_close_modal();">Cancel</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container my-5">



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
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $order->fetch_five(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- modal to edit an order -->
    <div id="order_modal">
        <form method="post" id="order_form">
                        <input type="hidden" name="order_id" id="order_id" />
                            <input type="date" class="form-control" name="date" id="date" />
                            <input type="time" class="form-control" name="time" id="time" />

                            <select name="status" id="status" class="form-select">
                                <option value="select" disabled>select</option>
                                <option value="Placed">Placed</option>
                                <option value="Preparing">Preparing</option>
                                <option value="Ready">Ready</option>
                            </select> 
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
                    <button type="button" id="del_notif_button" class="btn btn-success w-25" onclick="new Order().staff_delete_order();">Delete</button>
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
     /* instantiate JSTable class */
     let table = new JSTable("#order_table", {
        serverSide: true,
        deferLoading: <?php echo $order->count_all_data();?> ,
        ajax : "php/controller/f_order.php"
    });

order = new Order(table);
    order.staff_order();
</script>

</html>