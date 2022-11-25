<?php
require_once dirname(__FILE__) . "/../php/classes/Account.php";
require_once dirname(__FILE__) . "/../php/classes/Validate.php";

$account = new Account();
$validate = new Validate();

 /* checks if the verification code in the URL parameter is in the database */
$validate->validate_code();
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Password | Snackwise</title>
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

    <link rel="stylesheet" href="../css/new-password.css">

</head>

<body>


    <div class="parent-container">

        <div class="window-container">
        <a href="../index.php" class="snackwise-label text-decoration-none">
            <div class="brand-icon">
                <img src="../img/penguin.png" class="snackwise-icon" alt="Snackwise Logo">
            </div>
            <div class="brand-name">
                <span class="red">SNACK<span class="yellow">WISE</span></span>
            </div>
        </a>
            <div class="form-header">
                <h1>Create New Password</h1>
            </div>
            <form action="POST" id="account_form">
                <div class="input-container">
               <!--  onkeyup="new Account().verify_password(this.value);" -->
                    <input type="password" class="password" name="password" id="password" placeholder="Password" value=""  autocomplete="off">
                    <i class="fa-solid fa-eye-slash toggler" id="password_toggler" for="password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                    <span class="input_error" id="password_error" class="text-danger"></span>
                </div>
                <div class="input-container">
                    <input type="password" class="retype_password" name="retype_password" id="retype_password" placeholder="Retype Password" value="" autocomplete="off">
                    <i class="fa-solid fa-eye-slash toggler" id="retype_password_toggler" for="retype_password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                    <span class="input_error" id="retype_password_error" class="text-danger"></span>
                </div>
                <button id="new_password" class="new-password-btn" onclick=" new Account().new_password('<?php echo $_GET['code'] ?>');">Submit New Password</button>
            </form>
        </div>

    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../js/Account.js"></script>

    <script>
        //TEMPORARY
        // HIDE PASSWORD REQUIREMENTS

/*         document.getElementsByClassName("password_requirements").style.display = "none"; */

     
           
        
    </script>
</body>

</html>