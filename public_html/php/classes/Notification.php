<?php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';
require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Email.php";

class Notification extends DbConnection
{
     /* -------------------- notification */
    public function insert_notif( $user_id,$message) {
        $status = "unread";
        date_default_timezone_set('Asia/Manila');
        $date_time =  date("Y-m-d H:i:s");
        $query = $this->connect()->prepare("INSERT INTO notification ( user_id, message, date, status) VALUES( :user_id, :message, :date, :status)");
        $result = $query->execute([":user_id" => $user_id, ":message" => $message, ":date" => $date_time, ":status" => $status]);
    }

   /*  display all the notifications intended for the customer */
    public function display_notification($user_id)
    {
        $result = $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id =:user_id ORDER BY date DESC");
        $query->execute([":user_id" => $user_id]);
        if ($result) {
            $data = array();
            foreach ($result as $row) {
                $sub_array = array();
                $sub_array['notification_id'] = $row['notification_id'];
                $sub_array['user_id'] = $row['user_id'];
                $sub_array['message'] = $row['message'];
                $sub_array['date'] = $row['date'];
                $sub_array['status'] = $row['status'];
                $data[] = $sub_array;
            }
            $output = array("data"=>$data);
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /*  count all the unread notification of a customer */
    public function notification_count($user_id){
        $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id = :user_id AND status = :status");
        $query->execute([":user_id" => $user_id, ":status" => 'unread']);
        $output['notification_count'] = $query->rowCount();
        echo json_encode($output);
    }

    /* changes the status of notification from unread to read  */
    public function update_notification($user_id){
        $status = 'read';
        $query  = $this->connect()->prepare("UPDATE notification SET status = :status WHERE user_id = :user_id");
        $query->execute([':status' => $status, ':user_id' => $user_id]);
        echo json_encode("");
    }

     /* -------------------- newsletter*/
    public function newsletter($email) {
        $query = $this->connect()->prepare("INSERT INTO newsletter (email) VALUES( :email)");
        $result = $query->execute([":email" => $email]);
        if ($result) {
            $output['success'] = 'You have successfully subscribed to our newsletter.';
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
            
        }
        echo json_encode($output);
    }

    /* -------------------- contact-us.php */
    /* invoked when a customer submits a message from contact us  */
    public function send_email_message($name, $email,$subject,$message){
        $email_verification = new Email();
       if ($email_verification->sendEmail("Customer: ". $name,$email, $subject, $message, "contact")) {
        $output['success'] = 'Message sent successfully';
    } else {
        $output['error'] = 'Something went wrong! Please try again later.';
    }
       echo json_encode($output);
    }
}
