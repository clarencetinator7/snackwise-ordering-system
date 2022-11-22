<?php
require_once dirname(__FILE__) . '/../classes/Menu.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';

$menu = new Menu();
$validate = new Validate();

/* --------------------  */
if (isset($_POST["display_menu"])) {
    $category = $_POST["category"];
    $menu->display_menu($category);
}

/* --------------------  */
if (isset($_POST["display_bestseller"])) {
    $menu->display_bestseller();
}

/* --------------------  */
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

        $output = array();

        $validate->validateLength($name,'','name_error', 'Required field' );
        $validate->validateLength($description,'','description_error', 'Required field' );
        $validate->validateSelectorLength($category,'category_error', 'Required field' );
        $validate->validateLength($discount,'','discount_error', 'Required field' );
        $validate->validateLength($price,'','price_error', 'Required field' );
        $validate->validateLength($date,'','date_error', 'Required field' ); 
        $validate->validateSelectorLength($availability,'availability_error', 'Required field' );
        $validate->validateLength($image, '', 'image_error', 'Required field');

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

