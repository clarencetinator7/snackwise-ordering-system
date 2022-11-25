<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Snackwise</title>

    <!-- PAGE ICON -->
    <link rel="icon" href="../img/penguin.png" type="image/icon type">
         

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <!-- FONT AWESOME JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel="stylesheet" href="../css/login.css">

</head>

<body>

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
                <div class="row form-header">
                    <h3>Sign In</h3>
                    <span>Enter your account details to sign-in Snackwise</span>
                </div>
                <div class="">
                    <span id="success_message">
                        <?php
                        if (isset($_SESSION['activate_success'])) {
                            echo $_SESSION['activate_success'];
                            unset($_SESSION["activate_success"]);
                        } ?>
                    </span>

                    <span id="error_message"></span>
                </div>
                <section class="form-input-container">
                    <div class="row">
                        <div class="col">
                            <!-- <label for="user_identifier">Username / Email Address / Phone Number</label> -->
                            <input type="text" class="username-input" name="user_identifier" id="user_identifier" placeholder="Username / Email Address / Contact Number" value="" autocomplete="off">
                            <span class="input_error" id="user_identifier_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col password-container">
                            <!-- <label for="password">Password</label> -->
                            <input type="password" class="password-input" name="password" id="password" placeholder="Password" value="" onkeydown="/* verifyPassword(this.value) */" autocomplete="off">
                            <i class="fa-solid fa-eye-slash toggler" id="password_toggler" for="password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>

                            <span class="input_error" id="password_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="forgot-password.php" class="">Forgot Password?</a>
                        </div>
                    </div>
                </section>

                <section class="button-container">
                    <div class="row">
                        <div class="d-grid gap-2">
                            <button type="button" id="login" class="btn signin-btn" onclick="new Account().login()"> Sign In</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <span class="d-flex justify-content-center">Don't have an account?</span>
                            <div class="d-grid gap-2">
                                <button type="button" name="" id="" class="btn btn-warning signup-btn" onclick="location.href='register.php'">Create an Account</button>
                            </div>
                        </div>
                    </div>
                </section>

            </form>
        </div>

    </div>







<script src="../js/Account.js" ></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</body>

</html>