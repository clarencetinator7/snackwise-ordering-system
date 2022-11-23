<?php
require dirname(__FILE__) . '/../classes/Cart.php';
require dirname(__FILE__) . '/../classes/Validate.php';
$validate = new Validate();
$cart = new Cart();

/* -------------------- cart */
if (isset($_POST["add_to_cart"]) == 'add_to_cart') {
    $menu_id = $_POST['menu_id'];
    if ($validate->is_logged_in("customer")) {
        $output['error'] = "You must be logged in to order";
        echo json_encode($output);
    } else {
        $user_id = $_SESSION['user_id'];
        $cart->add_to_cart($user_id, $menu_id);
    }
}

if (isset($_POST["add_to_cart_count"]) == 'add_to_cart_count') {
    $user_id = $_SESSION['user_id'];
    $cart->add_to_cart_count($user_id);
}

if (isset($_POST["display_cart"])) {
    $user_id = $_SESSION['user_id'];
    $cart->display_cart($user_id);
}

if (isset($_POST["update_quantity"])) {
    $quantity = $_POST['quantity'];
    $cart_id = $_POST['cart_id'];
    $cart->update_quantity($cart_id,$quantity);
}
if (isset($_POST["delete_cart"])) {
    $cart_id = $_POST['cart_id'];
    $cart->delete_cart($cart_id);
}
if (isset($_POST["get_price"])) {
    $cart_id = $_POST['cart_id'];
    $cart->get_price($cart_id);
}
