class Menu {
    constructor(table) {
        this.table = table;

    }

    menu() {
        document.getElementById('modal_backdrop').style.display = 'none';
        document.getElementById("cart_summary").style.display = "none";
        /* default checked radio button */
        document.querySelectorAll('input[name="category"]')[0].checked = "checked";
        //gets the value of selected radio button which is used to filter the items in the menu table
        document.querySelectorAll('input[name="category"]')[0].parentElement.parentElement.id =
            "active-sort";
        document.querySelectorAll('input[name="category"]').forEach((radio) => {
            radio.addEventListener('change', function () {
                // removes styling of the unselected radio button
                document.querySelectorAll('input[name="category"]').forEach(function (
                    radio) {
                    radio.parentElement.parentElement.setAttribute("id", "");
                });
                (document.querySelector('input[name="category"]:checked').parentElement
                    .parentElement).id = "active-sort";
                new Menu().display_menu(document.querySelector('input[name="category"]:checked')
                    .value);
            });
            new Menu().display_menu(document.querySelector('input[name="category"]:checked').value);
        });
    }

    /* -------------------- index.php  */
    /* gets and displays available bestseller items */
    display_bestseller() {
        let form_data = new FormData();
        form_data.append('display_bestseller', 'display_bestseller');
        fetch('php/controller/c_menu.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.empty) {
                document.getElementById("bestseller_list").innerHTML = response_data.empty;
            } else {
                let bestseller_list = "";
                //iterate and append response data
                response_data.data.map(function (menu) {
                    bestseller_list += `
                    <div class="col-12 col-md-3 product position-relative">
                        <div class="product-img-container">
                            <img src="https://res.cloudinary.com/dhzn9musm/image/upload/${menu.image}" alt="combo a image" class="product-img">
                        </div>
                        <div class="product-details-container">
                            <div class="product-caption">
                                <span class="product-name">${menu.name}</span>
                                <span class="product-description">${menu.description}</span>
                            </div>
                            <div class="cart-container">`;
                    if (menu.discount != 0) {
                        bestseller_list += `    <div class="d-flex flex-column" ><span class="product-price" style="margin-bottom:-15px;">PHP ${(menu.discounted_price).toFixed(2).replace(/[.,]00$/, "")} </span><br>`;
                        bestseller_list += `  <span class=" h6 text-decoration-line-through" >PHP ${menu.price}</span></div>`;
                        /* menu_list += `  <div style="font-size:12px;"><span class=" text-decoration-line-through">PHP ${menu.price}</span> -${menu.discount}%</div>`; */
                    } else {

                        bestseller_list += `   <span class="product-price">PHP ${menu.price}</span>`;
                    }

                    bestseller_list += `   <span class="add-to-cart-container">
                                    <button class="add-to-cart-btn position-absolute" style="bottom:10px; right:10px;" type="submit" onclick="new Menu().add_best_cart(${menu.menu_id}); ">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                
                `;

                });
                document.getElementById("bestseller_list").innerHTML = bestseller_list;
            }
        });
    }

    /* invoked when a customer click the bestseller add to cart button */
    add_best_cart(menu_id) {
        window.location.href = `menu.php?b=${menu_id}`;
    }


    /* -------------------- menu.php  */
    /* gets and displays all available items */
    display_menu(category) {
        let form_data = new FormData();
        form_data.append('display_menu', 'display_menu');
        form_data.append('category', category);
        fetch('php/controller/c_menu.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.empty) {
                document.getElementById("menu_list").innerHTML = response_data.empty;
            } else {
                let menu_list = "";
                response_data.data.map(function (menu) {

                    /* if(menu.discount) */
                    menu_list += `
                <div class="col-12 col-md-6">
                    <div class="menu-item">
                    <div class="product-img">
                        <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${menu.image}' alt="food-img" food-img="">
                        </div>
                        <div class="product-details-wrapper">
                            <div class="product-details">
                                <span class="product-title">${menu.name}</span>
                                <span class="product-description">${menu.description}</span>
                               `;

                    if (menu.discount != 0) {
                        menu_list += `    <span class="product-price">PHP ${(menu.discounted_price).toFixed(2).replace(/[.,]00$/, "")} </span>`;

                        menu_list += `  <span class=" h6 text-decoration-line-through">PHP ${menu.price}</span>`;
                        /* menu_list += `  <div style="font-size:12px;"><span class=" text-decoration-line-through">PHP ${menu.price}</span> -${menu.discount}%</div>`; */
                    } else {
                        menu_list += `   <span class="product-price">PHP ${menu.price}</span>`;
                    }

                    menu_list += `  </div>
                            <div class="interact">
                                <button type="button" class="btn" onclick="new Cart().add_to_cart(${menu.menu_id});" name='${menu.menu_id}' id="add_to_cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                });

                /* adding event that checks if a customer is logged in or not once the add to cart button is clicked,
                if the user is not logged in a notification that requires the customer to log in will appear */
                document.getElementById("menu_list").innerHTML = menu_list;
                document.querySelectorAll("#temp_add_to_cart").forEach(function (button) {
                    button.onclick = function (e) {
                        let check_session_form = new FormData();
                        check_session_form.append('check_session', 'check_session');
                        fetch('php/controller/c_cart.php', {
                            method: "POST",
                            body: check_session_form
                        }).then(function (response) {
                            return response.json();
                        }).then(function (response_data) {
                            if (response_data.error) {
                                new Notification().create_notification(response_data.error, "error");
                            } else {
                                new Menu().open_add_cart();
                                document.getElementById("cart_menu_id").value = e.target.name;
                            }
                        });
                    }
                });
            }
        });
    }

    /* -------------------- STAFF -------------------- */
    /* -------------------- edit-menu.php  */
    action_menu_button() {
        document.getElementById('action_menu_button').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('action_menu_button').disabled = true;
        let form_data = new FormData(document.getElementById('menu_form'));
        console.log(form_data);
        fetch('php/controller/c_menu.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (document.getElementById('action_menu_button').value != "Edit") {
                dataAdded();
                document.getElementById('action_menu_button').innerHTML = "Add";
            } else {
                document.getElementById('action_menu_button').innerHTML = "Edit"
            }
            document.getElementById('action_menu_button').disabled = false;
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
                new Menu().close_menu();
                table.update();
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            } else {
                new Menu().scroll_to(Object.keys(response_data)[0]);
            }
            new Menu().show_error(response_data.name_error, 'name_error');
            new Menu().show_error(response_data.description_error, 'description_error');
            new Menu().show_error(response_data.category_error, 'category_error');
            new Menu().show_error(response_data.discount_error, 'discount_error');
            new Menu().show_error(response_data.price_error, 'price_error');
            new Menu().show_error(response_data.date_error, 'date_error');
            new Menu().show_error(response_data.availability_error, 'availability_error');
            new Menu().show_error(response_data.image_error, 'image_error');
        });
    }

    fetch_selected_menu(id) {
        new Menu().reset_error();
        let form_data = new FormData();
        form_data.append('id', id);
        form_data.append('fetch_selected_menu', 'fetch_selected_menu');

        fetch('php/controller/c_menu.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();

        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('menu_id').style.border = "none";
            document.getElementById('name').style.border = "none";
            document.getElementById('description').style.border = "none";
            document.getElementById('category').style.border = "none";
            document.getElementById('discount').style.border = "none";
            document.getElementById('availability').style.border = "none";
            document.getElementById('price').style.border = "none";
            document.getElementById('date').style.border = "none";
            document.getElementById('image_container').style.border = "none";

            document.getElementById('menu_id').value = response_data.menu_id;
            document.getElementById('name').value = response_data.name;
            document.getElementById('description').value = response_data.description;
            document.getElementById('category').value = response_data.category;
            document.getElementById('discount').value = response_data.discount;
            document.getElementById('availability').value = response_data.availability;
            document.getElementById('price').value = response_data.price;
            document.getElementById('date').value = response_data.date;

            document.getElementById('edit_menu_image').value = `${response_data.image}`;
            document.getElementById('show_menu_image').src = `https://res.cloudinary.com/dhzn9musm/image/upload/${response_data.image}`;

            document.getElementById('action_menu').value = 'Update';
            document.getElementById('modal_title').innerHTML = 'Edit Data';
            document.getElementById('action_menu_button').innerHTML = 'Edit';
            document.getElementById('action_menu_button').value = "Edit"
            new Menu().open_menu();

        });
    }

    delete_menu(menu_id) {
        if (confirm("Are you sure you want to remove it?")) {
            let form_data = new FormData();
            form_data.append('menu_id', menu_id);
            form_data.append('delete_menu', 'delete_menu');
            fetch('php/controller/c_menu.php', {
                method: "POST",
                body: form_data
            }).then(function (response) {
                return response.json();
            }).then(function (response_data) {
                console.log(response_data);
                if (response_data.success) {
                    new Notification().create_notification(response_data.success, "success");
                    dataRemoved();
                    table.update();
                } else if (response_data.error) {
                    new Notification().create_notification(response_data.error, "error");
                }
                
            });
        }
    }

    /* -------------------- */
    /* clears all the values of the input fields */
    reset_input() {
        document.getElementById('menu_form').reset();
        document.getElementById('action_menu').value = 'Add';
        document.getElementById('modal_title').innerHTML = 'Add Data';
        document.getElementById('action_menu_button').innerHTML = 'Add';
        document.getElementById('show_menu_image').src = "img/upload.jpg";
        new Menu().reset_error();
    }

    reset_error() {
        document.getElementById('name_error').innerHTML = '';
        document.getElementById('description_error').innerHTML = '';
        document.getElementById('category_error').innerHTML = '';
        document.getElementById('discount_error').innerHTML = '';
        document.getElementById('price_error').innerHTML = '';
        document.getElementById('date_error').innerHTML = '';
        document.getElementById('availability_error').innerHTML = '';
        document.getElementById('image_error').innerHTML = '';
    }

    /* display the uploaded image file to an image element */
    upload_image() {
        document.getElementById("upload_image").addEventListener("click", function () {
            document.getElementById("image").click();
            document.getElementById("image").addEventListener("change", function (e) {
                document.getElementById('edit_menu_image').value = "";
                document.getElementById('show_menu_image').src = window.URL.createObjectURL(
                    e.target.files[0]);
            });
        });
    }

    open_menu() {
        document.getElementById('modal_backdrop').style.display = 'block';
        document.getElementById('menu_modal').style.display = 'block';
        document.querySelector('body').style.overflow = 'hidden';

        document.getElementById('menu_modal').classList.add('show');
    }
    close_menu() {
        document.getElementById("menu_modal").scrollTo({
            top: 0
        });
        document.getElementById('modal_backdrop').style.display = 'none';
        document.getElementById('menu_modal').style.display = 'none';
        document.getElementById('menu_modal').classList.remove('show');
        document.querySelector('body').style.overflow = 'visible';
    }


    /* displays or removes error messages */
    show_error(error, element) {
        console.log(element.replace('_error', ''));
        error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
        if (error) {
            document.getElementById(element.replace('_error', '')).style.border = "red solid 1px";
            document.getElementById('image_container').style.border = "red solid 1px";
        } else {
            document.getElementById('image_container').style.border = "none";
            document.getElementById(element.replace('_error', '')).style.border = "none";
        }
    }

    /* scroll to the position of the input field with an error */
    scroll_to(element) {
        console.log(element);
        if (element == "top") {
            document.getElementById("menu_modal").scrollTo({
                top: 0,
                left: 0,
                behavior: "smooth"
            });
        } else {
            document.getElementById("menu_modal").scrollTo({
                top: (document.getElementById(element).offsetTop) - 250,
                left: 0,
                behavior: "smooth"
            });
        }
    }

}