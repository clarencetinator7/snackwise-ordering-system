class Cart {
    
    /* -------------------- cart */
    constructor() {
        document.getElementById('cartlist').style.display = "none";
    }

    cart() {
        new Cart().cart_count();
        new Cart().fetch_holiday();
        new Cart().display_cart();
        new Cart().close_add_order();
        
        
        /* redisplay the customers selected item for them to be able to verify their orders */
        document.getElementById('verify_order').onclick = function () {
            new Cart().open_add_order();
            let verify_list = "";

            let cart_id_list = (document.getElementById("cartlist").value).split(",");
            for(let i = 0; i<cart_id_list.length; i++) {
                let selected_cart_image =document.getElementById(`cart-image${cart_id_list[i]}`).src;
                let selected_cart_name = document.getElementById(`cart-name${cart_id_list[i]}`).innerHTML;
                let selected_cart_quantity = document.getElementById(`cart-quantity${cart_id_list[i]}`).value;
                console.log(cart_id_list[i]);
                verify_list += `
                    <div class="  pb-2" style="margin:7px;box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
                    border-radius: 20px; width:30%;" >
                        <img src='${selected_cart_image}' class="w-100"></img>
                        <div class="h6 text-center"><span class=" fw-bold">${selected_cart_name}</span> (x${selected_cart_quantity})</div>
                    </div>
                    `;
            }
            document.getElementById("verify_list").innerHTML = verify_list;
         
        }
        document.getElementById('add_to_order').onclick = function () {
            new Cart().add_to_order();
        }
    }

    


    /* gets and displays customers added to cart items */
    display_cart() {
        let form_data = new FormData();
        form_data.append('display_cart', 'display_cart');
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let cart_list = "";

            if (response_data.error) {
                document.getElementById("cart_list").innerHTML  = response_data.error;
            } else {
                response_data.data.map(function (cart) {
         
            cart_list += `
            <div class="cart_item d-flex align-items-center my-3 mx-1 p-2 position-relative">`
            if(cart.availability == "Available"){
            cart_list += `<input type="checkbox" class="" name='on_cart' value="${cart.cart_id}" data-price="${cart.total_discounted_price}" id="cart_${cart.cart_id}"/>`
            }
            cart_list += `   
            <div class="d-flex col">
            <img class=" cart-image mx-2 " id="cart-image${cart.cart_id}" src='https://res.cloudinary.com/dhzn9musm/image/upload/${cart.image}' alt="">
                <div class="d-flex flex-column">
                    <div class="item-name" id="cart-name${cart.cart_id}">${cart.name}</div>`
                    if(cart.availability == "Available"){  
                        if(cart.discount != 0){   
                            cart_list += `  <div class="">x<input id="cart-quantity${cart.cart_id}"  style="width:40px;" class="item-quantity" type="number" name="quantity_change" value="${cart.quantity}" data-cart-id="${cart.cart_id}"/><span  class=" ms-3 bolder item-price position-absolute" style="right:20px;">PHP ${(cart.discounted_price).toFixed(2).replace(/[.,]00$/, "")}</span></div>`;
                        } else {
                            cart_list += `  <div class="" >x<input id="cart-quantity${cart.cart_id}"  style="width:40px;" class="item-quantity" type="number" name="quantity_change" value="${cart.quantity}" data-cart-id="${cart.cart_id}" /><span  class="ms-3 bolder item-price position-absolute" style="right:20px;">PHP ${cart.price}</span></div>`;
                        }
                } else {
                    cart_list += `  <span class="ms-3 bolder item-price" style="margin-left:8px!important;">UNAVAILABLE</span>`;
                }
                cart_list += `      </div>
                </div>
              <i class="item-remove fa-solid fa-xmark ms-1 position-absolute" name='delete_cart'  onclick="new Cart().delete_cart(${cart.cart_id});" style="top:5px;right:5px;"></i>
            </div>
        `;
                });
            }
            document.getElementById("cart_list").innerHTML = cart_list;
            get_checkbox_status();

            /* keeps checkbox state */
            if(document.getElementById("cartlist").value != "") {
                let cart_id_list = (document.getElementById("cartlist").value).split(",");  
                for(let i = 0; i<cart_id_list.length; i++) {
                    document.getElementById(`cart_${cart_id_list[i]}`).checked=true;
        
                }
            }
            
            /* determines if the quantity has been changed,
            changes made will automatically be saved */
            document.querySelectorAll('input[name=quantity_change]').forEach(function (checkbox) {
                checkbox.onchange = function (e) {  
                
                /*  sets minimum and maximum values of the quantity */
                if(checkbox.value>99) {
                    checkbox.value=99;
                } 
                if(checkbox.value<1) {
                    checkbox.value=1;
                }      
                    let form_data = new FormData();
                    form_data.append('update_quantity', 'update_quantity');
                    form_data.append('cart_id', e.target.getAttribute('data-cart-id'));
                    form_data.append('quantity', e.target.value);
                    fetch('php/controller/c_cart.php', {
                        method: "POST",
                        body: form_data
                    }).then(function (response) {
                        return response.json();
                    }).then(function (response_data) { 
                        console.log(response_data);
                        new Cart().get_price();
                    });
                }
            });
        });

        /* determines if at least one item is selected, if true it will show the order button as well as the total price of all the selected item */
        function get_checkbox_status() {
            document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
                checkbox.onchange = function (e) {
                    document.getElementById("cartlist").value = get_checked(checkbox.name, "value");
                    new Cart().get_price();
                    var len = document.querySelectorAll('input[type="checkbox"]:checked').length
                    if (len <= 0) {
                        document.getElementById('cart_summary').style.display = "none";
                    } else {
                         document.getElementById('cart_summary').style.display = "flex";
                    }
                }
            });
        }

        /* gets the data-price attribute of the selected item */
        function get_checked(name, attribute) {
            let values = [];
            document.querySelectorAll('input[name="' + name + '"]:checked').forEach(function (checked) {
                if (attribute == "value") {
                    values.push(checked.value);
                } else {
                    values.push(checked.getAttribute("data-price"));
                }
            });
            return values;
        }

        

    }

    /* calculate the total price of all the selected item */
     get_price() {  
        let form_data = new FormData();
        form_data.append('get_price', 'get_price');
        form_data.append('cart_id', document.getElementById("cartlist").value);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) { 
            let total_discounted_price = 0;
            response_data.data.map(function (price) {
                total_discounted_price = total_discounted_price + parseFloat(price.total_discounted_price);
                console.log(total_discounted_price);
        });

        document.getElementById("cart_total_price").innerHTML = `PHP ${total_discounted_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        });    
    }

    delete_cart(cart_id) {
        let form_data = new FormData();
        form_data.append('delete_cart', 'delete_cart');
        form_data.append('cart_id', cart_id);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
           /*  console.log(response_data); */
           new Cart().display_cart();
           new Cart().cart_count();
           new Cart().get_price();

        });
    }



     /* add an item to the cart table */
     add_to_cart(menu_id) {

        let form_data = new FormData();
        form_data.append('add_to_cart', 'add_to_cart');
        form_data.append('menu_id', menu_id);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                new Cart().display_cart();
               /*  new Notification().create_notification(response_data.success, "success"); */
                new Cart().cart_count();
        /*         new Cart().cancel_cart(); */
                new Cart().open_cart();
            } else if (response_data.error){
                new Notification().create_notification(response_data.error, "error");
            }
        });
       
}

 /* gets customers cart items count */
 cart_count() {
    let form_data = new FormData();
    form_data.append('add_to_cart_count', 'add_to_cart_count');
    fetch('php/controller/c_cart.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        document.getElementById('cart_count').innerHTML = `(${response_data.cart_count})`;
    });
}

    open_cart() {
        document.getElementById('sidecart').style.display = "flex";
        document.getElementById('sidecart').style.animationName = "open_cart";
    }

     close_cart() {
        document.getElementById('sidecart').style.animationName = "close_cart";
    }

    

   

    /* transfers selected cart items to the order table */
    add_to_order() {
        document.getElementById('add_to_order').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('add_to_order').disabled = true;

        let form_data = new FormData(document.getElementById('order_form'));
        form_data.append('add_order', 'add_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);

            document.getElementById('add_to_order').innerHTML = "Checkout";
            document.getElementById('add_to_order').disabled = false;
            document.getElementById("cartlist").value = "";

            new Cart().display_cart();
            if (response_data.success) {
                /* new Notification().create_notification(response_data.success, "success");
                new Cart().close_add_order(); */
                window.location.href = "order.php?order=1"
            } else {
                new Notification().create_notification(response_data.error, "error");
            }
        });
    }

    /* fetches dates where the business is closed and removes it from the date picker */
    fetch_holiday() {
    
        let form_data = new FormData();
        form_data.append('display_holiday', 'display_holiday');

        fetch('php/controller/c_holiday.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();

        }).then(function (response_data) {
            let holiday_list = [];
           /* gets the current date and time and displays it to the date and time picker with a format of YYYY-MM-DD for date and HH: MM for time*/
            let date = new Date();
            let day = date.getDate(),
                month = date.getMonth() + 1,
                year = date.getFullYear(),
                hour = date.getHours(),
                min = date.getMinutes();

            month = (month < 10 ? "0" : "") + month;
            day = (day < 10 ? "0" : "") + day;
            hour = (hour < 10 ? "0" : "") + hour;
            min = (min < 10 ? "0" : "") + min;

            response_data.data.map(function (holiday) {
                holiday_list.push(holiday.date);
            });

            document.getElementById('date').flatpickr({
                "disable": holiday_list,
                minDate: "today",
                defaultDate: `${year}-${month}-${day}`
            });
            document.getElementById('time').flatpickr({
                enableTime: true,
                noCalendar: true,
                defaultDate: `${hour}:${min}`,
                maxTime: "20:00",
                minTime: "8:00",
                minuteIncrement: 15,
            });

        });
    }

    open_add_order() {
        document.getElementById("order_modal").style.display = "block";
        document.getElementById('modal_backdrop').style.display = 'block';
        document.querySelector('body').style.overflow = 'hidden';
    }

    close_add_order() { 
        document.getElementById("order_modal").style.display = "none";
        document.getElementById('modal_backdrop').style.display = 'none';
        document.querySelector('body').style.overflow = 'visible';
    }
}