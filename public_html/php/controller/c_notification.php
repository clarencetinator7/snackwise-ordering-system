<?php
require dirname(__FILE__) . '/../classes/Notification.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$validate = new Validate();
$notification = new Notification();
 /* -------------------- notification */
if (isset($_POST["display_notification"])) {
    $user_id = $_SESSION['user_id'];
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $notification->display_notification($user_id);
    }
}
if (isset($_POST["update_notification"]) == 'update_notification') {
    $user_id = $_SESSION['user_id'];
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $notification->update_notification($user_id);
    }
}

if (isset($_POST["notification_count"])) {
    $user_id = $_SESSION['user_id'];
  
        $notification->notification_count($user_id);
    
}
if (isset($_POST["newsletter"])) {
    $email = $_POST['email'];

    $validate->validateLength($email, 'email-contact', 'newsletter_email_error', 'Required field');

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $notification->newsletter($email);
    }
}

 /* -------------------- contact us */
if (isset($_POST["send_email_message"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $validate->validateLength($name, '', 'name_error', 'Required field');
    $validate->validateLength($email, 'email-contact', 'email_error', 'Required field');
    $validate->validateLength($subject, '', 'subject_error', 'Required field');
    $validate->validateLength($message, '', 'message_error', 'Required field');

    if (count($validate->output) > 0) {

        echo json_encode($validate->output);
    } else {
        $notification->send_email_message($name, $email, $subject, $message);
    }
}
