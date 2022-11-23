class Order {
    table;
    add_button;
    constructor(table) {
        this.qr_code_id = "";
        this.table = table;

    }

    customer_order() {
        new Order().close_order_details();
        //gets the value of selected radio button which is used to filter the items in the menu table
        document.querySelectorAll('input[name="category"]')[0].checked = "checked";

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
                new Order().display_order(document.querySelector('input[name="category"]:checked')
                    .value);
            });
            new Order().display_order(document.querySelector('input[name="category"]:checked').value);
        });
    }

    staff_order() {
        new Order().close_del_notif();
        document.getElementById("order_modal").style.display = "none";
        document.getElementById("preview").style.display = "none";


        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        /* returns the QR code scanned by the  scanner */
        scanner.addListener('scan', function (content) {
            console.log(content);
            new Order().order_fetch_info(content, "qr");
        });

        /* gets device camera */
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }

    /* -------------------- order.php */
    display_order(category) {
        let form_data = new FormData();
        if (category == "Completed") {
            form_data.append('display_completed_order', 'display_completed_order');
        } else {
            form_data.append('display_order', 'display_order');
        }
        form_data.append('category', category);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let order_list = "";
            let total_discounted_price = 0;
            if (response_data.error) {
                console.log(response_data.error);
                document.getElementById("order_list").innerHTML = response_data.error;
            } else {
                let current_order_id = 0;
                response_data.data.map(function (order) {
                    /* checks if the customer has multiple order */
                    if (order.order_id != current_order_id) {
                        /* display delete and download QR button only once */
                        order_list += `<hr>`;
                        order_list += `<hr>`;
                        if (order.status == "Placed") {
                            order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});">Delete</button>`;
                        } else {
                            order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});" disabled>Delete</button>`;
                        }
                    }
                    order_list += `
            <div class="text">
                <div >Order Id.: ${(order.order_id).toString().padStart(10, '0')}</div>
                <div >Qty: ${order.quantity_list}</div>
                <div >${order.status}</div>
                </div> 
            `;
                    total_discounted_price = total_discounted_price + parseFloat(order.total_discounted_price);
                    order_list += `
                    <button onclick="new Order().display_details(${order.order_id});">Details</button>
                    `;
                    order_list += `
                    <div>Total Amt: PHP ${total_discounted_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
                    `;
                });
                document.getElementById("order_list").innerHTML = order_list;
            }
        });
    }

    display_details(order_id) {
        let form_data = new FormData();
        form_data.append('display_details', 'display_details');
        form_data.append('order_id', order_id);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Order().open_order_details();
            let order_details_list = "";
            let current_order_id = 0;
            response_data.data.map(function (order) {
                if (order.order_id != current_order_id) {
                    /* display delete and download QR button only once */
                    order_details_list += `<hr>`;
                    order_details_list += `<hr>`;
                    order_details_list += `<hr>`;
                    if (order.status == "Placed") {
                        order_details_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});">Delete</button>`;
                    } else {
                        order_details_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});" disabled>Delete</button>`;
                    }
                }

                order_details_list += `
                    <div >Order Id.: ${(order.order_id).toString().padStart(10, '0')}</div>
                    <div >Qty: ${order.quantity_list}</div>
                    <div >Status:${order.status}</div>
                    <div >Order Date: ${order.date}</div>
                    <a  href='https://res.cloudinary.com/dhzn9musm/image/upload/${order.qr_image}' target="_blank" >
                    <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.qr_image}' width='40px' height='40px' ></img>
                    </a>
                    <div >Qty: ${order.quantity_list}</div>
                <div  ">${order.price_list}</div>
                <div  ">${order.description}</div>
                <div class="d-none ">${order.menu_name_list}</div>
                <div class="d-none ">:${order.category_list}</div>
                <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.image_list}' width='40px' height='40px' ></img>`
            });
            document.getElementById("order_details_list").innerHTML = order_details_list;

        });
    }

    delete_order(order_id) {
        if (confirm("Are you sure you want to cancel your order?")) {
        let delete_order_data = new FormData();
        delete_order_data.append('delete_order', 'delete_order');
        delete_order_data.append('order_id', order_id);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: delete_order_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
                table.update();
                dataRemoved();
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
            new Order().display_order();
        });
        }
    }



    /* -------------------- STAFF -------------------- */
    /* -------------------- edit-order.php */
    claim_order() {
        let form_data = new FormData();
        form_data.append('claim_order', 'claim_order');
        form_data.append('identifier', document.getElementById("to_claim_order_id").value);
        form_data.append('type', document.getElementById("to_claim_type").value);

        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Order().qr_close_modal();
            if (response_data.success) {
                table.update();
                dataRemoved();
                new Notification().create_notification(response_data.success, "success");

            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
        });
    }




    /* gets and displays the order information of to claim orders*/
    order_fetch_info(identifier, type) {

        //plays beep audio wehn a qr is scanned
        if (type == "qr") {
            new Audio('sound/beep.mp3').play();;
        }

        let form_data = new FormData();


        form_data.append('identifier', identifier);


        form_data.append('type', type);
        form_data.append('order_fetch_info', 'order_fetch_info');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            } else {
                let qr_to_claim_info = "";
                let qr_to_claim_price = "";
                let qr_to_claim_order = "";
                let order = response_data.data[0];
                let images = (order.image_list).split(', ');
                let orders = (order.menu_name_list).split(',');
                let prices = (order.price_list).split(',');
                let quantity = (order.quantity_list).split(',');
                let discount = (order.discount_list).split(',');
                let total_price = 0;
                console.log(images);
                qr_to_claim_info += `
      
        <div>${order.firstname} ${order.lastname}</div>
        <div>${order.date}</div>
        `;

                document.getElementById("to_claim_order_id").value = order.order_id;
                document.getElementById("to_claim_type").value = type;

                for (let i = 0; i < prices.length; i++) {
                    total_price += (parseFloat(prices[i]) - (parseFloat(prices[i]) * (parseFloat(discount[i]) / 100))) * parseFloat(quantity[i]);



                    qr_to_claim_order += `
        <div class="pb-2" style="margin:7px;box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
        border-radius: 20px; width:30%;">

        <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${images[i]}'  class="w-100"></img>
            <div class="h6 text-center"><span class=" fw-bold">${orders[i]}</span> (x${quantity[i]})</div>

            
        </div>  
        `;
                    console.log(`${images[i]}`);
                };
                qr_to_claim_price += `
          <div class="text-end fw-bold h6">PHP ${total_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
      `;

                if (type == "delete") {
                    console.log(identifier);
                    document.getElementById('to_delete_info').innerHTML = qr_to_claim_info;
                    document.getElementById('to_delete_order').innerHTML = qr_to_claim_order;
                } else {

                    document.getElementById("qr_to_claim_order").style.display = "block";
                    document.getElementById("qr_to_claim_order").style.display = "block";
                    document.getElementById('qr_to_claim_info').innerHTML = qr_to_claim_info;
                    document.getElementById('qr_to_claim_price').innerHTML = qr_to_claim_price;
                    document.getElementById('qr_to_claim_order').innerHTML = qr_to_claim_order;
                    document.getElementById("qr_modal").style.display = "block";
                    document.getElementById('modal_backdrop').style.display = 'block';
                    document.querySelector('body').style.overflow = 'hidden';
                }
            }
        });


    }

    toggle_camera() {
        if (document.getElementById("preview").style.display == "none") {
            document.getElementById("preview").style.display = "block";
        } else {
            document.getElementById("preview").style.display = "none";
        }
    }

    qr_close_modal() {
        this.qr_code_id = "";
        document.getElementById('modal_backdrop').style.display = 'none';
        document.getElementById("qr_modal").style.display = "none";
        document.getElementById("qr_to_claim_order").style.display = "none";
        document.getElementById("qr_to_claim_order").style.display = "none";
        document.querySelector('body').style.overflow = 'visible';
    }


    del_notif(order_id, user_id) {
        document.getElementById("del_notif_modal").style.display = "block";
        document.getElementById('modal_backdrop').style.display = 'block';
        document.getElementById("del_notif_order_id").value = order_id;
        document.getElementById("del_notif_user_id").value = user_id;
        document.querySelector('body').style.overflow = 'hidden';
        new Order().order_fetch_info(order_id, "delete");
    }
    close_del_notif() {
        document.getElementById('modal_backdrop').style.display = 'none';
        document.getElementById("del_notif_modal").style.display = "none";
        document.getElementById("del_notif_order_id").style.display = "none";
        document.getElementById("to_claim_order_id").style.display = "none";
        document.getElementById("to_claim_type").style.display = "none";
        document.getElementById("del_notif_order_id").value = "";
        document.getElementById("del_notif").value = "";

        document.getElementById("del_notif_user_id").style.display = "none";
        document.getElementById("del_notif_user_id").value = "";
        document.getElementById("del_notif").selectedIndex = 0;
        document.querySelector('body').style.overflow = 'visible';
    }


    /* -------------------- STAFF -------------------- */
    /* -------------------- edit-order.php */
    action_order_button() {
        let form_data = new FormData(document.getElementById('order_form'));
        form_data.append('action_order', 'Update')
        console.log(form_data);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
                table.update();
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
        });
    }

    fetch_selected_order(order_id, type) {
        console.log(order_id);
        let form_data = new FormData();
        form_data.append('order_id', order_id);
        form_data.append('fetch_selected_order', 'fetch_selected_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('order_id').value = response_data.order_id;
            if (type == "new") {
                document.getElementById('date').value = document.getElementById(response_data.order_id + 'new-date').value;
                document.getElementById('time').value = document.getElementById(response_data.order_id + 'new-time').value;
                document.getElementById('status').value = document.getElementById(response_data.order_id + 'new-status').value;
            } else {
                document.getElementById('date').value = document.getElementById(response_data.order_id + 'filter-new-date').value;
                document.getElementById('time').value = document.getElementById(response_data.order_id + 'filter-new-time').value;
                document.getElementById('status').value = document.getElementById(response_data.order_id + 'filter-new-status').value;
            }
            new Order().action_order_button();
        });
    }

    staff_delete_order() {
        let form_data = new FormData(document.getElementById('del_notif_form'));
        form_data.append('action_order', 'delete');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
                dataRemoved();
                table.update();
                new Order().close_del_notif();
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
            new Order().show_error(response_data.del_notif_error, 'del_notif_error');
        });
    }

    /* -------------------- */
    open_order_details() {
        document.getElementById('modal_backdrop').style.display = 'block';
        document.getElementById("order_details_modal").style.display = "block";
        document.querySelector('body').style.overflow = 'hidden';
    }
    close_order_details() {
        document.getElementById('modal_backdrop').style.display = 'none';
        document.getElementById("order_details_modal").style.display = "none";
        document.querySelector('body').style.overflow = 'visible';
    }

    /* displays or removes error messages */
    show_error(error, element) {
        console.log(element.replace('_error', ''));
        error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
        if (error) {
            document.getElementById(element.replace('_error', '')).style.border = "red solid 1px";
        } else {
            document.getElementById(element.replace('_error', '')).style.border = "none";
        }
    }

    /* scroll to the position of the input field with an error */
    scroll_to(element) {
        console.log(element);
        if (element == "top") {
            document.getElementById("order_modal").scrollTo({
                top: 0,
                left: 0,
                behavior: "smooth"
            });
        } else {
            document.getElementById("order_modal").scrollTo({
                top: (document.getElementById(element).offsetTop) - 250,
                left: 0,
                behavior: "smooth"
            });
        }
    }
}