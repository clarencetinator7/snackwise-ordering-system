<?php
require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Email.php";
require_once dirname(__FILE__) . "/Image.php";

class Account extends DbConnection
{
    /* -------------------- login.php  */
    public function login($user_identifier, $table_identifier, $password)
    {
        /* checks if the information entered exist  */
        $query  = $this->connect()->prepare("SELECT user_id ,email, password, attempt, user_type,status FROM user where " . $table_identifier . " = :user_identifier");
        $query->execute([':user_identifier' => $user_identifier]);
        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $fetch_pass = $fetch['password'];
            $fetch_user_id = $fetch['user_id'];
            $fetch_attempt = $fetch['attempt'];
            $fetch_user_type = $fetch['user_type'];
            $fetch_status = $fetch['status'];
            $fetch_email = $fetch['email'];

            /* verify if the password entered and the password in the database matches, if true login incorrect attempt counter will be reset to 0 else it will be increased by 1 */
            if (password_verify($password, $fetch_pass)) {
                $query  = $this->connect()->prepare("UPDATE user SET attempt = :attempt WHERE user_id = :user_id");
                $result = $query->execute([':attempt' => '0', ':user_id' => $fetch_user_id]);
                if ($result) {
                    /* checks if the account is verified or not, if the account is still unverified it will resend a verificatione email to the user */
                    if ($fetch_status == "verified") {
                        $_SESSION['user_id'] = $fetch_user_id;
                        $_SESSION['password'] = $password;
                        $_SESSION['user_type'] = $fetch_user_type;
                        $output['success'] = '<div class="alert alert-success text-center">Login Successfully</div>';
                    } else {
                        $code = $this->generate_code();
                        if ($fetch_user_type == "customer") {
                            $email =  $fetch_email;
                            $subject = 'SnackWise Account Verification';
                            $notice = "Click the button <br> below to verify your account."; 
                        } else {
                            $email = $this->get_admin_email();
                            $subject = 'SnackWise Staff Account Verification';
                            $notice = "Click the button <br> below to verify " . $fetch_email.".";
                        }

                        $link = "/account/activate.php?code=" . $code ;
                        $body = $this->email_template( $link, $notice );

                        if ($this->update_code($email, $subject, $body, $code)) {
                            $_SESSION['forgot-email'] = $email;
                            $output['validate'] = '<div class="alert alert-danger text-center">You still haven\'t verify your account.Verification code has been sent to ' . $email . '</=div>';
                        } else {
                            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
                        }
                    }
                }
            } else {
                $query =  $this->connect()->prepare("UPDATE user SET attempt = :fetch_attempt WHERE user_id = :fetch_user_id");
                $result = $query->execute([':fetch_attempt' =>  $fetch_attempt + 1, ':fetch_user_id' => $fetch_user_id]);
                if ($result) {
                    $output['error'] = '<div class="alert alert-danger text-center">Incorrect Password</div>';
                } else {
                    $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
                }
            }
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
        }
        echo json_encode($output);
    }

    /* -------------------- register.php  */
    public function register($firstname, $lastname, $username, $email, $contact, $password, $user_type)
    {
        $attempt = 0;
        $status = "unverified";
        $code = $this->generate_code();
        $code_expiration = $this->get_current_date();
        $encrypt_password = $this->encrypt_password($password);
        $query = $this->connect()->prepare("INSERT INTO user (firstname, lastname, username, email, contact, password, attempt,code,code_expiration, status, user_type) VALUES( :firstname, :lastname, :username, :email, :contact, :password, :attempt,:code, :code_expiration,:status, :user_type)");
        $result = $query->execute([":firstname" => $firstname, ":lastname" => $lastname, ":username" => $username, ":email" => $email, ":contact" => $contact, ":password" => $encrypt_password, ":attempt" => $attempt, ":code" => $code, ":code_expiration" => $code_expiration, ":status" => $status, ":user_type" => $user_type]);
        if ($result) {

            /* user_type determines wether the person registering is a customer or staff,
            if it is equal to customer, the email verification will be sent to the entered emeil address, 
            else it will be send to the admin email address */
            if ($user_type == "customer") {
                $email=$email;
                $subject = 'SnackWise Account Verification';
                $notice = "Click the button <br> below to verify your account." . $user_type;
            } else {
                $email = $this->get_admin_email();
                $subject = 'SnackWise Staff Account Verification';
                $notice = "Click the button <br> below to verify " . $user_type.".";
            }
            $link = "/account/activate.php?code=" . $code;
            $body = $this->email_template( $link, $notice );

            $email_verification = new Email();
            if ($email_verification->sendEmail("SnackWise", $email, $subject, $body, "account")) {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                if ($user_type == "customer") {
                    $output['success'] = '<div class="alert alert-success text-center">Verification code has been sent to ' . $email . '</div>';
                } else {
                    $fetch_email = $this->get_admin_email();
                    $output['success'] = '<div class="alert alert-success text-center">Verification code has been sent to ' . $fetch_email . '</div>';
                }
            } else {
                $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
            }
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
        }
        echo json_encode($output);
    }

    /* -------------------- forgot-password.php  */
    /* when a user (both customer and staff) forgot their password, they can change their password using the link that will be sent to their email address*/
    public function forgot_password($user_identifier, $table_identifier)
    {
        $query  = $this->connect()->prepare("SELECT email, username, contact FROM user where " . $table_identifier . " = :table_identifier");
        $query->execute([':table_identifier' => $user_identifier]);
        $code = $this->generate_code();
        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $fetch_email = $fetch['email'];
            $subject = 'SnackWise Forgot Password';
            $notice = "Click the button <br> to change your password.";  
            //the link will redirect the user to account/new-password
           
            $link = "/account/new-password.php?code=" . $code;
            $body = $this->email_template( $link, $notice );
            if ($this->update_code($fetch_email, $subject, $body, $code)) {
                $_SESSION['forgot-email'] = $fetch_email;
                $output['success'] = '<div class="alert alert-success text-center">Link to change your password has been sent to ' . $fetch_email . '</div>';
            } else {
                $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
            }
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
        }
        echo json_encode($output);
    }


    /* -------------------- new-password.php  */
    public function new_password($user_id, $password)
    {
        $status = 'verified';
        $code = 0;
        $attempt = 0;
        $encrypt_password = $this->encrypt_password($password);
        $query = $this->connect()->prepare("UPDATE user SET password = :password, code = :code, attempt = :attempt, status = :status WHERE user_id = :user_id");
        $result = $query->execute([':password' => $encrypt_password, ':code' => $code,  ':attempt' => $attempt, ':status' => $status, ':user_id' => $user_id]);
        if ($result) {
            $output['success'] = '<div class="alert alert-success text-center">Your password has been changed! Please login with your new password</div>';
            $_SESSION['activate_success'] =  '<div class="alert alert-success text-center">Your password has been changed! Please login with your new password</div>';
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
        }
        echo json_encode($output);
    }

    /* -------------------- activate.php */
    /* changes the status of the user account to verified */
    public function activate()
    {
        $url_code = $_GET["code"];
        $status = "verified";
        $code = 0;
        /* checks if the verification code in the URL parameter exists */
        $query  = $this->connect()->prepare("UPDATE user SET code = :code, status = :status WHERE code = :url_code");
        $result = $query->execute([':code' => $code, ':status' => $status, ':url_code' => $url_code]);
        if ($result) {
            $_SESSION['activate_success'] = '<div class="alert alert-success text-center">Your account has been activated</div>';
            header('Location: login.php');
        } else {
            header('Location: ../error');
        }
    }
   /* -------------------- reset.php */
    /* changes the login incorrect attempt counter to 0 */
    public function reset_attempt()
    {
        $url_code = $_GET["code"];
        $code = 0;
        $attempt = 0;
        $query  = $this->connect()->prepare("UPDATE user SET code = :code, attempt = :attempt WHERE code = :url_code");
        $result = $query->execute([':code' => $code,  ':attempt' => $attempt, ':url_code' => $url_code]);
        if ($result) {
            $_SESSION['activate_success'] = '<div class="alert alert-success text-center">Your account has been verified. You can now login</div>';
            header('Location: login');
        } else {
            header('Location: error');
        }
    }

    /* -------------------- */
     /* updates verification code */
     public function update_code($email, $subject, $body, $code)
     {
         $code_expiration = $this->get_current_date();
         $query =  $this->connect()->prepare("UPDATE user SET code = :code, code_expiration = :code_expiration WHERE email = :email");
         $result = $query->execute([':code' => $code, ':code_expiration' => $code_expiration, ':email' => $email]);
         if ($result) {
             $email_verification = new Email();
             if ($email_verification->sendEmail("SnackWise", $email, $subject, $body, "account")) {
                 return true;
             } else {
                 return false;
             }
         } else {
             return false;
         }
     }
 
/* sends an email verification when the maximum login incorrect attempt has been met */
public function email_attempt($user_identifier, $table_identifier)
{
    $query  = $this->connect()->prepare("SELECT email FROM user where " . $table_identifier . " = :table_identifier");
    $query->execute([':table_identifier' => $user_identifier]);
    if ($query->rowCount() > 0) {
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $fetch_email = $fetch['email'];
        $code = $this->generate_code();
        $email = $fetch_email;
        $subject = 'SnackWise Reset Login Attempts';
        $link = "/account/reset.php?code=" . $code;
        $notice = "Click the button <br> below to verify your account.";
        $body = $this->email_template( $link,  $notice );
        if ($this->update_code($email, $subject, $body, $code)) {
            $_SESSION['forgot-email'] = $email;
            $output['error'] = '<div class="alert alert-danger text-center">Too many incorrect login attempts. We have sent an email to verify your identity.</div>';
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
        }
    }
    echo json_encode($output);
}

    /* generates email verification code */
    public function generate_code()
    {
        $code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1, 16))), 1, 16);

        /* check if the verification code already exists, if true it will regenerate again */
        $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
        $query->execute([':code' => $code]);

        if ($query->rowCount() > 0) {
            $code = $this->generate_code();
        } else {
            return $code;
        }
    }

    /* deletes verification codes that exist for more than the specified expiration time */
    public function delete_code()
    {
        $query  = $this->connect()->prepare("UPDATE user SET code =:code  WHERE UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(code_expiration) >= :unixtime");
        /* 86400 seconds is equal to 1 day */
        $query->execute([':code' => "", ':unixtime' => 86400]);
    }

    /* returns current date and time  */
    public function get_current_date()
    {
        date_default_timezone_set('Asia/Manila');
        return  date('Y-m-d H:i:s');
    }

    /* encrypts  entered password */
    public function encrypt_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /* gets admin registered email address */
    public function get_admin_email()
    {
        $query = $this->connect()->prepare("SELECT email FROM user WHERE user_type = :user_type");
        $result = $query->execute([":user_type" => "admin"]);

        if ($result) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            return $fetch['email'];
        } else {
            $output['error'] = '<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>';
            echo json_encode($output);
        }
    }

     /* email content template */
     public function email_template($link, $notice) {
        return "
        <body
        style='font-family:Roboto, sans-serif; font-size: 18px;text-align: center; background-image:url(https://res.cloudinary.com/dhzn9musm/image/upload/v1668344633/SnackWise/Background-Pattern_dpqbdy.jpg); margin: 0; padding: 0;'>
        <table style='width: 100%;'>
            <tr>
                <td style='  vertical-align: middle;'>
                    <table style=' margin:0 auto; padding: 50px 20px 80px 20px;'>
                        <tr>
                            <td>
                                <h1><span style='color: #DD1C1A;'>SNACK</span><span
                                        style='color: #F0C808; text-align: center;'>WISE</span></h1>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table
                                    style='background-color: white!important; border-radius: 20px; padding: 100px 20px; width: 500px;'>
                                    <tr>
                                        <td style='color:black!important;'>
                                            " . $notice . "
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button style='width: 100%; margin: 20px 0; font-weight: 600px;  font-size: 18px;padding: 20px 0; border-radius: 10px;border:none;background-color: #DD1C1A; color: white;'> <a style =' color: white; text-decoration: none' href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . $link . "'>Verify Your Account</a></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='color:black!important;'>
                                            If the button does not work for any reason, you can <br> also paste the
                                            following into your browser:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding-top:15px; color:black!important;'>
                                        <a style='font-size:16px!important; overflow-wrap: break-word;'  href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . $link . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . $link . "</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr >
                            <td style='font-size:17px; padding-top:15px;'>
                                The link will expire after a day.
                            </td>
                        </tr>
                        <tr>
                            <td style='font-size:15px; padding-top:5px;'>
                                Copyright © <script>
                                    document.write(new Date().getFullYear())
                                </script> Snackwise. All Rights Reserved.
                            </td>
                        </tr>
                        <tr>
                            <td style='opacity: 0;'>
                                <script>
                                    document.write(Date.now())
                                </script>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
        ";
    }
}
