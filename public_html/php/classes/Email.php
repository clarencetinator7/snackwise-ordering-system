<?php
    require dirname(__FILE__) .'/../PHPMailer/PHPMailerAutoload.php';

    class Email {
        public function sendEmail($name, $email, $subject, $body, $type) {
            
            $from = "snackwise.hagonoy@gmail.com";
            $password = "gesjppxbvxkswodb";

            date_default_timezone_set('Etc/UTC');
            $mail = new PHPMailer();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            if($type == "contact") {
                $email = "snackwise.hagonoy@gmail.com";
                $mail->addAddress($email);
                $mail->addReplyTo($email);
                $mail->setFrom($name);
      
            } else if($type == "account") {
                $mail->addAddress($email);
            }  
            
            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";
            $mail->isSMTP();
            $mail->Host = gethostbyname('ssl://smtp.gmail.com');
            $mail->Host = 'smtp.gmail.com';
            $mail->Subject = $subject;
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = $from;
            $mail->FromName = $name;
            $mail->Password = $password;

            $mail->msgHTML($body);
            return $mail->send();
        }
    }
