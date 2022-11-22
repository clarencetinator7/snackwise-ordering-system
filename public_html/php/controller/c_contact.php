<?php
require dirname(__FILE__) . '/../classes/Account.php';
require dirname(__FILE__) . '/../classes/Validate.php';
$account = new Contact();

if (isset($_POST["contactus"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $user_type = $_POST['user_type'];

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->contact($firstname, $lastname, $username, $email, $contact, $password, $retype_password, $region, $province, $municipality, $barangay, $street, $user_type);
    }
}
