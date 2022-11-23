<?php
require_once dirname(__FILE__) . '/../classes/Menu.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';

$menu = new Menu();
$validate = new Validate();

/* -------------------- index.php */
if (isset($_POST["display_bestseller"])) {
    $menu->display_bestseller();
}

/* -------------------- menu.php */
if (isset($_POST["display_menu"])) {
    $category = $_POST["category"];
    $menu->display_menu($category);
}

/* -------------------- STAFF --------------------  */
/* -------------------- edit-menu.php */
if (isset($_POST["action_menu"])) {
    if ($_POST['action_menu'] == 'Add' || $_POST['action_menu'] == 'Update') {
        $menu_id = $_POST["menu_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $category = $_POST["category"];
        $discount = $_POST["discount"];
        $price = $_POST["price"];
        $date = $_POST["date"];
        $availability = $_POST["availability"];
        $edit_menu_image = $_POST["edit_menu_image"];

         /* determines if the image of a menu has been changed */
        if ($_POST["edit_menu_image"] == "") {
            $image = $_FILES["image"]["tmp_name"];
        } else {
            $image = $_POST["edit_menu_image"];
        }

        $validate->validate_length($name,'','name_error', 'Required field' );
        $validate->validate_length($description,'','description_error', 'Required field' );
        $validate->validate_selector_length($category,'category_error', 'Required field' );
        $validate->validate_length($discount,'','discount_error', 'Required field' );
        $validate->validate_length($price,'','price_error', 'Required field' );
        $validate->validate_length($date,'','date_error', 'Required field' ); 
        $validate->validate_selector_length($availability,'availability_error', 'Required field' );
        $validate->validate_length($image, '', 'image_error', 'Required field');

        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
            if ($_POST['action_menu'] == 'Add') {
                $menu->add_menu($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image);
            }
            if ($_POST['action_menu'] == 'Update') {
                $menu->edit_menu($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image, $edit_menu_image);
            }
        }
    }
}
    if (isset($_POST['fetch_selected_menu'])) {
        $menu->fetch_selected_menu();
    }

    if (isset($_POST['delete_menu'])) {
        $menu_id = $_POST["menu_id"];
        $menu->delete_menu($menu_id);
    }

