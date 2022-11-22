<?php
require_once dirname(__FILE__) . '/../classes/Account.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';
$account = new Account();
$validate = new Validate();

/* -------------------- login.php */
if (isset($_POST["login"])) {
    $user_identifier = $_POST['user_identifier'];
    $password = $_POST['password'];
    $validate->validate_length($password, 'login', 'password_error', 'Required field');
    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');
    $validate->user_identifier($table_identifier, $user_identifier, 'user_identifier_error');
    $validate->validate_length($user_identifier, '', 'user_identifier_error', 'Required field');
    /* checks if the validation above returns an error or not, if true it will display the error */
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        /* checks if the maximum login incorrect attempt has been reached, if true it will invoke the email_attept function and sends an email verification to the user */
        if( $validate->login_attempt($user_identifier, $table_identifier)) {
            $account->login($user_identifier,$table_identifier,$password);
        } else {
            $account->email_attempt($user_identifier, $table_identifier);
        }
    }
}

/* -------------------- register.php */
if (isset($_POST["register"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
    $user_type = $_SESSION['user_type'];
    $validate->validate_length($firstname,'','firstname_error', 'Required field' );
    $validate->validate_length($lastname,'', 'lastname_error', 'Required field' );
    $validate->validate_length($contact,'', 'contact_error', 'Required field' );
    $validate->validate_length($username, '', 'username_error', 'Required field' );
    $validate->validate_length($email,'', 'email_error', 'Required field' );
    $validate->validate_length($password, $retype_password, 'password_error', 'Required field' );
    $validate->validate_length($password,$retype_password, 'retype_password_error', 'Required field' );
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
         $account->register($firstname, $lastname, $username, $email, $contact, $password, $user_type);
    }
}

/* -------------------- forgot-password.php */
if (isset($_POST["forgot_password"])) {
    $user_identifier = $_POST['user_identifier'];
    $validate->validate_length($user_identifier, '', 'user_identifier_error', 'Required field');
    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->forgot_password($user_identifier, $table_identifier);
    }
}

/* -------------------- new-password.php */
if (isset($_POST["new_password"])) {
    $url_code = $_GET['code'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
    $validate->validate_length($password, $retype_password, 'password_error', 'Required field' );
    $validate->validate_length($password,$retype_password, 'retype_password_error', 'Required field' );
    $user_id = $validate->get_user_id($url_code);
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->new_password($user_id, $password);
    }
}