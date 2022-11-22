<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Reset | Snackwise</title>
    <!-- PAGE ICON -->
    <link rel="icon" href="../img/penguin.png" type="image/icon type">

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- BOOTSTRAP JS  -->


    <!-- FONT AWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel="stylesheet" href="../css/forgotpassword.css">
</head>

<body>

    <div class="parent-container">
        <div class="form-window">
        <a href="../index.php" class="snackwise-label text-decoration-none">
            <div class="brand-icon">
                <img src="../img/penguin.png" class="snackwise-icon" alt="Snackwise Logo">
            </div>
            <div class="brand-name">
                <span class="red">SNACK<span class="yellow">WISE</span></span>
            </div>
        </a>
            <div class="back-container">
                <a href="login.php"><i class="fa-solid fa-arrow-left"></i> Back to Login</a>
            </div>
            <div class="form-header">
                <h1>Forgot Password</h1>
            </div>
            <form action="POST" id="account_form">
                <span id="success_message" class="text-success"></span>
                <span id="error_message" class="text-success"></span>
                <input type="text" name="user_identifier" id="user_identifier" placeholder="Username / Email Address / Contact Number" value="" autocomplete="off">
                <span id="user_identifier_error" class="input_error"></span>
                <button type ="button"  id="forgot_password" onclick=" new Account().forgot_password();">Submit</button>
            </form>
        </div>
    </div>
    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../js/Account.js"></script>
    
</body>

</html>