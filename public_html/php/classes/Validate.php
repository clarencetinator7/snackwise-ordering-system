<?php
require_once dirname(__FILE__) . "/DbConnection.php";

class Validate extends DbConnection
{
  public $output = array();

  /* checks if an input field is empty or not,
   if the input field is not empty, further input validation will be performed */
  public function validate_length($input, $compare_input, $name, $message)
  {
    if (isset($input) && $input == '') {
      $this->output[$name] = $message;
    } else {
      unset($this->output[$name]);
      /* checks if the entered value (email, username, and phone number) is taken or not */
      if (strpos($name, "identifier") !== false) {
        if ($this->is_email($input) == "email") {
          if ($this->is_taken_email($input)) {
            $this->output[$name] = 'Account not found';
          } else {
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        } else  if ($this->is_contact($input) == "contact") {
          if ($this->is_taken_contact($input)) {
            $this->output[$name] = 'Account not found';
          } else {
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        } else {
          if ($this->is_taken_username($input)) {
            $this->output[$name] = 'Account not found';
          } else {
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        }
      }

      /* checks if a user does not select an item in dropdown */
      if (strpos($name, "category")) {
        if ($input == "select") {
          $this->output[$name] = $message;
        }
      }
      if (strpos($name, "email") !== false) {
        if ($this->is_email($input)) {
          if ($compare_input != "email-contact" && $compare_input != "email-newsletter") {
            if ($this->is_taken_email($input)) {
              unset($this->output[$name]);
            } else {
              $this->output[$name] = 'Email address is taken';
            }
          } else if($compare_input == "email-newsletter") {
            if ($this->is_newsletter_registered($input)) {
              unset($this->output[$name]);
            } else {
              $this->output['error'] = 'You are already subscribed';
            }
          }
        } else {
          $this->output[$name] = 'Invalid email address';
        }
      }
      if (strpos($name, "contact") !== false) {
        if ($this->is_contact($input)) {
          if ($this->is_taken_contact($input)) {
            unset($this->output[$name]);
          } else {
            $this->output[$name] = 'Phone number is taken';
          }
        } else {
          $this->output[$name] = 'Invalid phone number';
        }
      }
      if (strpos($name, "username") !== false) {
        if ($this->is_taken_username($input)) {
          unset($this->output[$name]);
        } else {
          $this->output[$name] = 'Username is taken';
        }
      }
      if (strpos($name, "password") !== false && $compare_input != "login") {
        if ($this->has_meet_password($input)) {
          unset($this->output[$name]);
        } else {
          $this->output['password_error'] = 'Password does not meet the requirements';
        }
      }
      if (strpos($name, "retype_password") !== false) {
        if ($this->is_match($input, $compare_input)) {
          unset($this->output[$name]);
        } else {
          $this->output['retype_password_error'] = 'Passwords do not match';
        }
      }
      if (strpos($name, "discount") !== false || strpos($name, "price") !== false) {
        if (ctype_digit(str_replace(", ", "", $input))) {
          unset($this->output[$name]);
        } else {
          $this->output[$name] = 'Enter a valid number';
        }
      }
    }
  }

  /* -------------------- functions */

  /* determines if the password entered and the password in the database matches */
  public function match_current_password($current_password, $user_id)
  {
    $query = $this->connect()->prepare("SELECT password FROM user where  user_id = :user_id");
    $result = $query->execute([':user_id' => $user_id]);
    if ($result) {
      $fetch = $query->fetch(PDO::FETCH_ASSOC);
      $fetch_pass = $fetch['password'];

      if (password_verify($current_password, $fetch_pass)) {
        return true;
      } else {
        $output['current_password_error'] = 'Incorrect Password';
        echo json_encode($output);
      }
    }
  }

  /* determines if the user met the maximum login incorrect attempt */
  public function login_attempt($user, $table)
  {
    $query = $this->connect()->prepare("SELECT attempt FROM user where " . $table . " = :email AND attempt >= 3");
    $query->execute([':email' => $user]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if a user does not select an item in dropdown */
  public function validate_selector_length($input, $name, $message)
  {
    if ($input == "none") {
      $this->output[$name] = $message;
    } else {
      $this->output[$name] = '';
      unset($this->output[$name]);
    }
  }

  /* determines if the entered value in the contact field is a valid phone number */
  public function is_contact($input)
  {
    if (strlen($input) == 11 && is_numeric($input) && substr($input, 0, 2 ) === "09") {
      return true;
    } else {
      return false;
    }
  }

  /* determines if the entered value in the email field is a valid email address */
  public function is_email($input)
  {
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }


  /* checks if the password and retype password entered matches */
  public function is_match($input, $compare_input)
  {
    if ($input == $compare_input) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if the password entered met the password requirement */
  public function has_meet_password($input)
  {/* ^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%^&,*.]{8,16}$ */
    /* it must have 8-20 alphanumeric and must have at least one lowercase, uppercase and special character */
    if (preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[@#$%^&,*.]).{8,16}$/', $input)) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if the phone number entered is taken */
  public function is_taken_contact($input)
  {
    $query = $this->connect()->prepare("SELECT contact FROM user where contact = :contact");
    $query->execute([':contact' => $input]);
    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if the email entered is taken */
  public function is_taken_email($input)
  {
    $query = $this->connect()->prepare("SELECT email FROM user where email = :email");
    $query->execute([':email' => $input]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  /* checks if the email entered is already subscribed to newsletter */
  public function is_newsletter_registered($input)
  {
    $query = $this->connect()->prepare("SELECT email FROM newsletter where email = :email");
    $query->execute([':email' => $input]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if the username entered is taken */
  public function is_taken_username($input)
  {
    $query = $this->connect()->prepare("SELECT username FROM user where username = :username");
    $query->execute([':username' => $input]);
    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* checks if the verification code in the URL parameter is in the database */
  public function validate_code()
  {
    if (isset($_GET["code"])) {
      $url_code = $_GET["code"];
      $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
      $query->execute([':code' => $url_code]);
      if ($query->rowCount() > 0) {
        return  true;
      } else {
        header('location: ../error.php');
      }
    } else {
      header('location: ../error.php');
    }
  }

  /* gets the user_id where the verification code in the URL parameter is assigned*/
  public function get_user_id($url_code)
  {
    $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
    $query->execute([':code' => $url_code]);
    if ($query->rowCount() > 0) {
      $fetch = $query->fetch(PDO::FETCH_ASSOC);
      $fetch_user_id = $fetch['user_id'];
      return  $fetch_user_id;
    } else {
      return false;
    }
  }

  /* determines whether the login credentials that a user entered is a username, email, or phone number */
  public function table_identifier($input, $name)
  {
    if ($this->is_email($input)) {
      return "email";
    } else if ($this->is_contact($input)) {
      return "contact";
    } else {
      return "username";
    }
  }

  public function user_identifier($table, $user, $name)
  {
    if ($this->is_email($user) == "email") {
      if ($this->is_taken_email($user)) {
        $this->output[$name] = 'Account not found';
      } else {
        unset($this->output[$name]);
      }
    } else   if ($this->is_contact($user) == "contact") {
      if ($this->is_taken_contact($user)) {
        $this->output[$name] = 'Account not found';
      } else {
        unset($this->output[$name]);
      }
    } else {
      if ($this->is_taken_username($user)) {
        $this->output[$name] = 'Account not found';
      } else {
        unset($this->output[$name]);
      }
    }
  }

  /* determines if a user is logged in and if it is a customer or an employee */
  public function is_logged_in($type)
  {
    if ($type == "customer") {
      if (isset($_SESSION['user_id']) == false && isset($_SESSION['password']) == false) {
        return true;
      } else {
        return false;
      }
    } else {
      if (isset($_SESSION['user_id']) == true && isset($_SESSION['password']) == true) {
        if (isset($_SESSION["user_type"]) && $_SESSION['user_type'] == "user") {
          return true;
        } else {
          return false;
        }
      } else {
        header('Location: account/login.php');
      }
    }
  }

  public function sanitizeString($input)
  {
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS);
  }
}
