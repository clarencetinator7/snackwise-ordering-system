<?php
require dirname(__FILE__) . '/../classes/Order.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';

$order = new Order();
$validate = new Validate();



/* order.php */
if (isset($_POST["display_order"])) {
    $user_id = $_SESSION['user_id'];
    $order->display_order($user_id);
}
if (isset($_POST["display_completed_order"])) {
    $user_id = $_SESSION['user_id'];
    $order->display_completed_order($user_id);
}
if (isset($_POST["delete_order"])) {
    $order_id = $_POST['order_id'];
    $order->delete_order($order_id);
}

/* cart.php */
if (isset($_POST["add_order"]) == 'add_order') {
    $cartlist = $_POST['cartlist'];
    $user_id = $_SESSION['user_id'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $order->add_order($user_id, $cartlist, $date, $time);
}

if (isset($_POST["qr_claim_order"]) == 'qr_claim_order') {
    $identifier = $_POST['identifier'];
    $type = $_POST['type'];

    $order->claim_order($identifier,$type);
}


if (isset($_POST["order_fetch_info"]) == 'order_fetch_info') {
    $identifier = $_POST['identifier'];
$type = $_POST['type'];
    $order->order_fetch_info($identifier,$type);
}

















/* --------------------admin */
if (isset($_POST["action_order"])) {

    if ($_POST['action_order'] == 'Update') {


        $order_id = $_POST["order_id"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $status = $_POST["status"];

        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
    
  $order->admin_edit_order($order_id,  $date, $time, $status);
            
        }
    }
   




    if ($_POST['action_order'] == 'delete') {

        $del_notif = $_POST['del_notif'];
        
        
        $order_id = $_POST['order_id'];
        $user_id = $_POST['user_id'];
        $validate->validateLength($del_notif,'','del_notif_error', 'Required' );
       


        
        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
            $order->admin_delete_order($order_id, $user_id, $del_notif);
        }
    }
} 

if (isset($_POST['fetch_selected_order'])) {
    $order_id = $_POST['order_id'];
    $order->fetch_selected_order( $order_id);
}


/* 
if (isset($_POST["display_menu"])) {
    $order->display_menu();
}
 */