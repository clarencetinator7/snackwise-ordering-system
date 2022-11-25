class Account {

    /* -------------------- login.php */
    login() {
        /* changes button text to font awesome loading spinner */
        let button_value = new Account().get_button_value("login");
        new Account().button_loading("login", "loading", "");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('login', 'login');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Account().button_loading("login", "", button_value);
            /* displays the message returned */
            if (response_data.success) {
                document.getElementById('success_message').innerHTML = "";
                window.location.href = "../index.php";
            } else if (response_data.validate) {
                document.getElementById('success_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = response_data.validate;
            } else if (response_data.error) {
                document.getElementById('success_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
            new Account().show_error(response_data.password_error, 'password_error');
        });
    }

    /* -------------------- register.php */
    register() {
        let button_value = new Account().get_button_value("register");
        new Account().button_loading("register", "loading", "");
        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('register', 'register');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            new Account().button_loading("register", "", button_value);
            if (response_data.success) {
                document.getElementById('firstname').value = "";
                document.getElementById('lastname').value = "";
                document.getElementById('username').value = "";
                document.getElementById('email').value = "";
                document.getElementById('contact').value = "";
                document.getElementById('password').value = "";
                document.getElementById('retype_password').value = "";
                document.getElementById('success_message').innerHTML = response_data.success;
                console.log(response_data);
                new Account().scroll_to("top");
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
                new Account().scroll_to("top");
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.firstname_error, 'firstname_error');
            new Account().show_error(response_data.lastname_error, 'lastname_error');
            new Account().show_error(response_data.username_error, 'username_error');
            new Account().show_error(response_data.email_error, 'email_error');
            new Account().show_error(response_data.contact_error, 'contact_error');
            new Account().show_error(response_data.password_error, 'password_error');
            new Account().show_error(response_data.retype_password_error, 'retype_password_error');
        });
    }

    /* -------------------- forgot-password.php */
    forgot_password() {

        let button_value = new Account().get_button_value("forgot_password");
        new Account().button_loading("forgot_password", "loading", "");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('forgot_password', 'forgot_password');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Account().button_loading("forgot_password", "", button_value);
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
                document.getElementById('user_identifier').value = "";
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
        });
    }

    /* -------------------- new-password.php  */
    new_password(url_code) {
        let button_value = new Account().get_button_value("new_password");
        new Account().button_loading("new_password", "loading", "");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('new_password', 'new_password');
        fetch(`../php/controller/c_account.php?code=${url_code}`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Account().button_loading("new_password", "", button_value);
            if (response_data.success) {
                /* document.getElementById('success_message').innerHTML = response_data.success; */
                window.location.href = "login.php";
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.password_error, 'password_error');
            new Account().show_error(response_data.retype_password_error, 'retype_password_error');
        });
    }

    /* -------------------- profile.php */
    /* displays user information */
    fetch_information() {
        
        let form_data = new FormData();
        form_data.append('fetch_information', 'fetch_information');
        return fetch('php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let user = response_data;

            
            document.getElementById('cropped_image').value="";
            document.getElementById("firstname").value = `${user.firstname}`;
            document.getElementById("lastname").value = `${user.lastname}`;
            document.getElementById("email").value = `${user.email}`;
            document.getElementById("username").value = `${user.username}`;
            document.getElementById("contact").value = `${user.contact}`;
            document.getElementById("cropped_image").value = `${user.image}`;
            new Account().crop_close_modal(user.image);
            if(user.image != "") {
               document.getElementById("display_image_modal").href = `https://res.cloudinary.com/dhzn9musm/image/upload/${user.image}`;
               document.getElementById("display_image").src = `https://res.cloudinary.com/dhzn9musm/image/upload/${user.image}`;
            } else {
                 document.getElementById("display_image").src = `img/no-image.jpg`; 
                 document.getElementById("display_image_modal").href =  `img/no-image.jpg`; 
            }
            let counter = 0;
            if(counter<=0) {
            lightGallery(document.getElementById('image_modal'), {
                counter:false,
                download:true,
                backdropDuration: 100,
                selector: 'a',
                
            }); 
            counter++;
        }
        });

        
    }

    /* updates user information  */
    update(type) {
        if(type == "email") {
            new Account().button_loading("update_email", "loading", "");

        } else {
            new Account().button_loading("update", "loading", "");
        }

        let form_data = new FormData(document.getElementById('account_form'));
        form_data.append('type', type);
        form_data.append('update', 'update');
        fetch('php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            if(type == "email") {
                new Account().button_loading("update_email", "", "Change Email Address");
            } else {
                new Account().button_loading("update", "", "Edit Profile");
            }
           
            console.log(response_data);
            if (response_data.success) {
                if(type != "email") {
                    new Account().fetch_information();
                }
                new Notification().create_notification(response_data.success, "success");
                /* new Account().scroll_to("top"); */
                window.location.reload();
            } 
            else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
                new Account().scroll_to("top");
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            
            if(type == "email") {
                new Account().show_error(response_data.email_error, 'email_error');
            } else {
                new Account().show_error(response_data.firstname_error, 'firstname_error');
                new Account().show_error(response_data.lastname_error, 'lastname_error');
                new Account().show_error(response_data.username_error, 'username_error');
                new Account().show_error(response_data.contact_error, 'contact_error');
            }
        });
    }

    crop_close_modal(image) {
        document.getElementById('image').style.display = "none";
        document.getElementById('cropped_image').style.display = "none";
        document.getElementById('crop_modal').style.display = "none";
        document.getElementById('cropped_image').value = image;
        document.getElementById('modal_backdrop').style.display = 'none';
        document.querySelector('body').style.overflow = 'visible';
    }

    /* -------------------- */
    show_error(error, element) {
        console.log(element.replace('_error', ''));
        error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
        error ? document.getElementById(element.replace('_error', '')).style.border = "red solid 1px" : document.getElementById(element.replace('_error', '')).style.border = "none";

    }
    /* toggles input field type attribute value to text or password */
    toggle_password(passwordToggler, passwordField) {
        document.getElementById(passwordField).setAttribute('type', (document.getElementById(passwordField).getAttribute('type') === 'password') ? 'text' : 'password');
        document.getElementById(passwordToggler).classList.toggle('fa-eye');
        document.getElementById(passwordToggler).classList.toggle('fa-eye-slash');
    }

    /* display a checkmark if the specific password requirement has been met, otherwise it will display an x */
    verify_password(password) {
        document.querySelector(".length").style.opacity = 1;
        document.querySelector(".case").style.opacity = 1;
        document.querySelector(".special").style.opacity = 1;
        document.querySelector(".number").style.opacity = 1;
        let caseRequirments = /^(?=.*[a-z])(?=.*[A-Z])/;
        let specialRequirments = /(?=.*[!@#$%^&,*.])/;
        let numberRequirments = /(?=.*\d)/;

        (password.length >= 8 && password.length <= 16) ? document.getElementById("length").innerHTML = "&#x2714": document.getElementById("length").innerHTML = "&#x2716";
        (password.match(caseRequirments)) ? document.getElementById("case").innerHTML = "&#x2714": document.getElementById("case").innerHTML = "&#x2716";
        (password.match(specialRequirments)) ? document.getElementById("special").innerHTML = "&#x2714": document.getElementById("special").innerHTML = "&#x2716";
        (password.match(numberRequirments)) ? document.getElementById("number").innerHTML = "&#x2714": document.getElementById("number").innerHTML = "&#x2716";
    }

    /* disables the button and changes its content to a loading animation so the user can not click while the server is processing */
    button_loading(element, type, text) {
        if (type == "loading") {
            document.getElementById(element).innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            document.getElementById(element).disabled = true;
        } else {

            document.getElementById(element).innerHTML = text;
            document.getElementById(element).disabled = false;
        }
    }

    /* gets button text */
    get_button_value(element) {
        return document.getElementById(element).innerHTML;
    }

    /* scroll to the position of the input field with an error */
    scroll_to(element) {
        if (element == "top") {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: "smooth"
            });
        } else {
            window.scrollTo({
                top: (document.getElementById(element).offsetTop) - 250,
                left: 0,
                behavior: "smooth"
            });
        }
    }

}