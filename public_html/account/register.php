<?php
require_once dirname(__FILE__) . '/../php/classes/DbConnection.php';
if (isset($_GET["staff"]) == 1) {
    $_SESSION['user_type'] = 'staff';
} else {
    $_SESSION['user_type'] = "customer";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Snackwise</title>

    <!-- PAGE ICON -->
    <link rel="icon" href="../img/penguin.png" type="image/icon type">


    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <link rel="stylesheet" href="../css/register.css">

    <style>

    </style>
</head>

<div class="parent-container">

    <div class="container p-5 form-container">
        <a href="../index.php" class="snackwise-label text-decoration-none">
            <div class="brand-icon">
                <img src="../img/penguin.png" class="snackwise-icon" alt="Snackwise Logo">
            </div>
            <div class="brand-name">
                <span class="red">SNACK<span class="yellow">WISE</span></span>
            </div>
        </a>
        <form id="account_form" method="POST">

            <div class="row">
                <div class="col form-header">
                    <h3>Sign Up</h3>
                </div>
            </div>
            <div class="">
                <span id="success_message"></span>
                <span id="error_message"></span>
            </div>
            <section class="personal-information-sec input section">
                <div class="row">
                    <span class="group-title">Personal Information</span>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 form-group">
                        <!-- <label for="firstname">First Name</label> -->
                        <input type="text" class="m-2" name="firstname" id="firstname" placeholder="First Name" value="" autocomplete="off">
                        <span class="input_error" id="firstname_error"></span>
                    </div>
                    <div class="col-md-6 col-12 form-group">
                        <!-- <label for="lastname">Last Name </label> -->
                        <input type="text" class="m-2" name="lastname" id="lastname" placeholder="Last Name" value="" autocomplete="off">
                        <span class="input_error" id="lastname_error"></span>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- <label for="contact">Contact Number</label> -->
                        <input type="text" class="m-2" name="contact" id="contact" placeholder="Contact Number (09XXXXXXXXX)" value="" autocomplete="off">
                        <span class="input_error" id="contact_error"></span>
                    </div>
                </div>
            </section>

            <section class="account-information-sec input-section">
                <div class="row">
                    <span class="group-title">Account Information</span>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <!-- <label for="username">Username</label> -->
                        <input type="text" class="m-2" name="username" id="username" placeholder="Username " value="" autocomplete="off">
                        <span class="input_error" id="username_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <!-- <label for="email">Email Address</label> -->
                        <input type="text" class="m-2" name="email" id="email" placeholder="Email Address" value="" autocomplete="off">
                        <span class="input_error" id="email_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 form-group password-container">
                        <!-- <label for="password">Password</label> -->
                        <input type="password" class="m-2" name="password" id="password" placeholder="Password" value="" onkeyup="new Account().verify_password(this.value);" autocomplete="off">
                        <i class="fa-solid fa-eye-slash toggler" id="password_toggler" for="password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                        <span class="input_error" id="password_error"></span>
                    </div>
                    <div class="col-12 form-group password-container">
                        <!-- <label for="retype_password">Retype Password</label> -->
                        <input type="password" class="m-2" name="retype_password" id="retype_password" placeholder="Retype Password" value="" autocomplete="off">
                        <i class="fa-solid fa-eye-slash toggler" id="retype_password_toggler" for="retype_password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                        <span class="input_error" id="retype_password_error"></span>
                    </div>
            </section>

            <div class="row">
                <div class="col">
                    <p class="text-end">Already have an account? <a href="../account/login.php">Sign In</a></p>
                </div>
            </div>
            <div class="form-end-btn">
                <div class="">
                    <a href="../index.php" id="cancel">Cancel</a>
                </div>
                <div class="">
                    <button type="button" id="register" class="btn btn-primary" onclick="new Account().register();"> Register</button>
                </div>

            </div>
        </form>

    </div>

</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script src="../js/Account.js"></script>

<script>
  

</script>


</html>