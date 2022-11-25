<?php
/* this page is used to change email address */
require_once dirname(__FILE__) . "/../php/classes/Account.php";
require_once dirname(__FILE__) . "/../php/classes/Validate.php";

$validate = new Validate();

$account = new Account();
$user_id = $_GET['u'];
$email = $_GET['email'];

/* checks if the verification code in the URL parameter is in the database */
if ($validate->validate_code()) {
    $account->update($user_id, "", "", "", $email, "", "", "new_email");
    header('Location: ../profile.php');
}


