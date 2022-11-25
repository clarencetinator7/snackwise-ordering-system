<?php
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("customer")) {
    header('Location: account/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>



    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <title>Document</title>
    <link rel="stylesheet" href="css/notification.css">
    <link rel="stylesheet" href="css/profile.css">
</head>


<body>



    <div class="parent-container">
        <!-- START OF NAVBAR -->
        <nav class="navbar navbar-light bg-light navbar-expand-md">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <!-- <img src="./img/penguin.png" alt="Penguin Logo" height="58" width="52"> -->
                    <span class="red">SNACK</span><span class="yellow">WISE</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto nav-list">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link" id="">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <?php
                    if ($validate->is_logged_in("customer")) {
                    ?>
                        <form action="#" class="form-inline sign-btns">
                            <a name="log-in-btn" class="btn" href="account/login.php">Login</a>
                            <a name="sign-up-btn" id="" class="btn btn-primary" href="account/register.php" role="button">Sign Up</a>
                        </form>
                    <?php
                    } else {

                    ?>
                         <div class="fw-bold h6" style="margin-top: 5px;"><?php echo $_SESSION['current_firstname'] . " " . $_SESSION['current_lastname']; ?></div>
                        <div class="user-dropdown-container">
                            <button class="user-button"></button>
                           <img src="https://res.cloudinary.com/dhzn9musm/image/upload/<?php echo $_SESSION['current_image']?>" alt="" style="border-radius:100px; width:50px; height:50px">
                       
                            
                            
                                <!-- <i class="fa-solid fa-circle-user"></i> -->
                            </button>
                            <ul class="drop-menu">
                            <div id="notification_list" class="position-absolute r-0" style="max-height:300px; min-width:400px; overflow:auto; "></div>
                            </ul>
                    </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
        </nav>
        <!-- END OF NAVBAR -->

        <!-- START PROFILE CONTENT -->
        <div class="container p-5 profile-container">
            <div class="card-title">
                <h1>Edit Profile</h1>
                <hr>
            </div>

            <div class="row flex-container">

                <div id="image_modal" class="col-md-4 image_modal mb-5">
                    <a class="display_image_modal" id="display_image_modal" href="">
                        <img class="display_image" id="display_image" src="" alt="">
                    </a>

                    <button type="button" class="choose_image" id="choose_image"><i class="fa-solid fa-camera"></i></button>
                </div>

                <!-- right column -->
                <div class="col personal-info">
                    <form class="form-horizontal" role="form" id="account_form" method="">
                        <section class="form-input-container">

                            <div class="row form-header">
                                <h3>Personal Information:</h3>
                            </div>

                            <div class="form-group mt-3">
                                <label class="col control-label">First name:</label>
                                <div class="col">
                                    <input class="form-control" type="text" name="firstname" id="firstname" value="" placeholder="First Name" autocomplete="off">
                                    <span class="input_error" id="firstname_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col control-label">Last name:</label>
                                <div class="col">
                                    <input class="form-control" type="text" name="lastname" id="lastname" value="" placeholder="Last Name" autocomplete="off">
                                    <span class="input_error" id="lastname_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col control-label">Username:</label>
                                <div class="col">
                                    <input class="form-control" type="text" name="username" id="username" placeholder="Username" autocomplete="off">
                                    <span class="input_error" id="username_error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Contact Number:</label>
                                <div class="col">
                                    <input class="form-control" type="text" name="contact" id="contact" value="" placeholder="09 - -" autocomplete="off">
                                    <span class="input_error" id="contact_error"></span>
                                </div>
                            </div>
                            <input type="file" class="image" name="image" id="image" value="" />
                            <input id="cropped_image" value="" name="crop_image"></input>
                        </section>

                        <section class="button-container">
                            <div class="row">
                                <div class="col">
                                    <div class="d-grid gap-2">
                                        <button type="button" id="update" class="btn btn-outline-danger edit-btn" id="update" onclick="new Account().update('other');"> Edit Profile</button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="row form-header mt-5">
                            <h3>Change Email?</h3>
                        </div>

                        <div class="form-group">
                            <!--       <label class="col control-label">Email:</label> -->
                            <div class="col">
                                <input class="form-control" type="text" name="email" id="email" value="" placeholder="- - - @gmail.com" autocomplete="off">
                                <span class="input_error" id="email_error"></span>
                            </div>
                            <div class="col">
                                <div class="d-grid gap-2">
                                    <button type="button" id="update_email" class="btn btn-outline-danger update-btn" onclick="new Account().update('email');"> Update Email</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>



        <div class="modal" id="crop_modal">
            <div class="modal-dialog" style="">
                <div class="modal-content">
                    <div class="modal-header ">
                        <div class="modal-title h5 fw-bold">CROP IMAGE</div>
                          <div  id="cancel"  style="color:#A3A3A3;   font-size: 2em"; onclick="new Account().crop_close_modal('<?php echo $_SESSION['current_image']?>');"><i class="fa-solid fa-xmark" style="color:#A3A3A3; font-size:20px;"></i></div>
                    </div>
                    <div class="modal-body">

                        <div class="result w-100" id="result" style="height:400px;"></div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn w-25" id="crop" style="background-color: rgb(221,28,26); color: white;">Crop</button>
        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show" id="modal_backdrop"></div>

        </form>
        <!-- toast_notif notification will be appended here -->
        <div class="toast_notif" id="toast_notif"></div>

        <script src="js/Notification.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>

        <!-- BOOTSTRAP JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/video/lg-video.umd.js'></script>


        <script src="js/Account.js"></script>

</body>

<script>
    new Account().fetch_information();
    crop_image();
    new Account().scroll_to("top");
    function crop_image() {

        /* opens file input on button click  */

        document.getElementById("choose_image").addEventListener("click", function() {
            document.getElementById("image").click();
        });

        let result = document.getElementById('result');
        /* open image cropper */
        document.getElementById("image").addEventListener("change", function(e) {
            if (e.target.files.length) {
                const reader = new FileReader();
                reader.onload = e => {
                    if (e.target.result) {
                        let img = document.createElement('img');
                        img.id = 'image';
                        img.src = e.target.result;
                        result.innerHTML = '';
                        result.appendChild(img);
                        cropper = new Cropper(img, {
                            dragMode: 'move',
                            restore: false,
                            center: true,
                            cropBoxResizable: true,
                        });
                    }
                };

                /* crop uploaded image */
                document.getElementById('crop').addEventListener('click', function(e) {
                    e.preventDefault();
                    let img_src = cropper.getCroppedCanvas({
                        width: "1000",
                    }).toDataURL();
                    new Account().crop_close_modal('<?php echo $_SESSION['current_image']?>');
                    document.getElementById('cropped_image').value = img_src;
                    document.getElementById('display_image').src = img_src;
                    document.getElementById('display_image_modal').href = img_src;
                });

                document.getElementById('modal_backdrop').style.display = 'block';
                document.getElementById('crop_modal').style.display = 'block';
                document.querySelector('body').style.overflow = 'hidden';
                document.getElementById('crop_modal').style.display = "block";
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    <?php
    /* adds selected bestseller item to cart */
    if (isset($_SESSION['activate_success'])) {
    ?>
        new Notification().create_notification("Your email address has been updated", "success");
    <?php
        unset($_SESSION["activate_success"]);
    }

    ?>
</script>

</html>