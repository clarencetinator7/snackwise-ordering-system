class Order {
    table;
    add_button;
    constructor(table) {
        this.qr_code_id = "";
        this.table = table;
    }


    display_order() {
        let order_form_data = new FormData();
        order_form_data.append('display_order', 'display_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: order_form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let order_list = "";
            
            let total_discounted_price = 0;
            console.log(response_data);
            if (response_data.error) {
                document.getElementById("order_list").innerHTML = response_data.error;
            } else {
               
                    let current_order_id = 0;
                response_data.data.map(function (order) {
                    /* checks if the customer has multiple order */
                    if(order.order_id != current_order_id ) {
                    /* display delete and download QR button only once */
                    
                    order_list += `<hr>`;
                    current_order_id = order.order_id; 
                    if(order.status == "Placed") {
                        order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});">Delete</button>`;
                  
                    }  else {
                        order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});" disabled>Delete</button>`;
                        order_list += `<a href='https://res.cloudinary.com/dhzn9musm/image/upload/${order.qr_image}' target="_blank" width='40px' height='40px'>
                        Download QR
                          </a>`;
                    }
                    } 
                    order_list += `
            <div class="text">
            
            <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.image_list}' width='40px' height='40px'></img>
                <div>${order.order_id}</div>
                <div>${order.menu_name_list}</div>
                <div>${order.quantity_list}</div>
                <div>${order.category_list}</div>
                <div>${order.price_list}</div>
                <div>${order.status}</div>
            </div>  
            `;
      
                    total_discounted_price = total_discounted_price + parseFloat(order.total_discounted_price);
                    order_list += `
                    <div>PHP ${total_discounted_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
                    `;
                });
             
            }
            
            document.getElementById("order_list").innerHTML = order_list;

            lightGallery(document.getElementById('order_list'), {
                animateThumb: false,
                zoomFromOrigin: false,
                allowMediaOverlap: true,
                toggleThumb: false,
                hideControlOnEnd : true,
                selector: 'a',
                controls: false,
                enableDrag : false,
                enableSwipe: false,
                keyPress: false,
                counter : false
                
            });
        });

        
     
    }

    display_completed_order() {
        let order_form_data = new FormData();
        order_form_data.append('display_completed_order', 'display_completed_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: order_form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let order_list = "";
            let total_discounted_price = 0;
            console.log(response_data);
            if (response_data.error) {
                document.getElementById("order_list").innerHTML = response_data.error;
            } else {
                console.log(response_data.data[0].order_id);
                /*  get_notification(); */

    /* determined if a customer canceled its order, 
    if an order has been canceled, the table will be reloaded */
    function get_notification() {
     
        let pusher = new Pusher('56c2bebb33825a275ca8', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('snackwise');
        channel.bind('notif', function(data) {
            let notif = data['notification']['notif'];
            table.update();
            dataRemoved();
        });
    }
                response_data.data.map(function (order) {
                    let current_order_id = 0;
                    if(order.order_id != current_order_id ) {
                        /* display delete and download QR button only once */
                        
                        current_order_id = order.order_id; 
                     
                        order_list += `<hr>`;
                        order_list += ` <div>${order.date}</div>`;
                     
                        } 
                    order_list += `
            <div class="text">
            <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.image_list}' width='40px' height='40px'></img>
                <div>${order.order_id}</div>
                <div>${order.menu_name_list}</div>
                <div>${order.quantity_list}</div>
                <div>${order.category_list}</div>
                <div>${order.price_list}</div>
            </div>
            `;
                    total_discounted_price = total_discounted_price + parseFloat(order.total_discounted_price);
                    order_list += `
                    <div>PHP ${total_discounted_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
                    `;
                });
            }
            document.getElementById("order_list").innerHTML = order_list;
        });
    }

    delete_order(order_id) {
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
            new Order().display_order();
        });
    }



/* -------------------- */
qr_claim_order() {
    let form_data = new FormData();
    form_data.append('qr_claim_order', 'qr_claim_order');
    form_data.append('identifier',  document.getElementById("to_claim_order_id").value);
    form_data.append('type',  document.getElementById("to_claim_type").value);

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
            new Notification().create_notification(response_data.success,"success");
      
         } else if (response_data.error) {
             new Notification().create_notification(response_data.error,"error");
         }
    });
}

/* 
claim_order(order_id,user_id) {
    if(confirm("Are you sure you want to claim order# " + order_id)) {
    let form_data = new FormData();
    form_data.append('claim_order', 'claim_order');
        form_data.append('order_id', order_id);
        form_data.append('user_id', user_id);
    console.log(form_data);
    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        console.log(response_data);
        new Order().qr_close_modal();
    });

}
}
 */

/* gets and displays the order information of to claim orders*/
order_fetch_info(identifier,type) {

    //plays beep audio wehn a qr is scanned
 if(type == "qr") {
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
        if(response_data.error) {
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
        let total_price=0;
        console.log(images);
        qr_to_claim_info += `
      
        <div>${order.firstname} ${order.lastname}</div>
        <div>${order.date}</div>
        `;

        document.getElementById("to_claim_order_id").value = order.order_id;
        document.getElementById("to_claim_type").value = type;

        for (let i = 0; i < prices.length; i++) {
              total_price += (parseFloat(prices[i]) - (parseFloat(prices[i]) * (parseFloat(discount[i])/ 100))) * parseFloat(quantity[i]); 
       


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
      
      if(type == "delete") {
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
    if(document.getElementById("preview").style.display == "none") {
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
    new Order().order_fetch_info(order_id,"delete");
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













action_order_button() {



    let form_data = new FormData(document.getElementById('order_form'));
    form_data.append('action_order','Update')
    console.log(form_data);
    fetch('php/controller/c_order.php', {

        method: "POST",
        body: form_data

    }).then(function (response) {

        return response.json();

    }).then(function (response_data) {

        console.log(response_data);
        if (response_data.success) {
            /* document.getElementById('success_message').innerHTML = response_data.success; */
            new Notification().create_notification(response_data.success,"success");
       
            table.update();
            let action_order_button = document.getElementById('action_order_button').value;
            console.log(action_order_button);
           

                document.getElementById('action_order_button').innerHTML = "Edit"

            
            document.getElementById('action_order_button').disabled = false;
        }  else if (response_data.error) {
            new Notification().create_notification(response_data.error,"error");
       
        } 
        
 
    });
}

fetch_selected_order(order_id,type) {
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
        document.getElementById('customer_name').value = response_data.customer_name;
        document.getElementById('order_name').value = response_data.menu_name;
        document.getElementById('price').value = response_data.price;
        document.getElementById('quantity').value = response_data.quantity;
        document.getElementById('contact').value = response_data.contact;

if(type == "new") {
    document.getElementById('date').value =  document.getElementById(response_data.order_id+'new-date').value;
        document.getElementById('time').value = document.getElementById(response_data.order_id+'new-time').value;
        document.getElementById('status').value = document.getElementById(response_data.order_id+'new-status').value;


} else {
    document.getElementById('date').value =  document.getElementById(response_data.order_id+'filter-new-date').value;
        document.getElementById('time').value = document.getElementById(response_data.order_id+'filter-new-time').value;
        document.getElementById('status').value = document.getElementById(response_data.order_id+'filter-new-status').value;

}
        


        document.getElementById('action_order').value = 'Update';
        document.getElementById('modal_title').innerHTML = 'Edit Data';
        document.getElementById('action_order_button').innerHTML = 'Edit';
        document.getElementById('action_order_button').value = "Edit"
      /*   new Order().open_modal(); */
        new Order().action_order_button();

    });
}

delete_data() {
    let form_data = new FormData(document.getElementById('del_notif_form'));
    form_data.append('action_order', 'delete');
    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        if(response_data.success) {
            new Notification().create_notification(response_data.success,"success");
            dataRemoved();
            table.update();
            new Order().close_del_notif();
        } else if(response_data.error) {
            new Notification().create_notification(response_data.error,"error");
        }
        new Order().show_error(response_data.del_notif_error, 'del_notif_error');

    });
}

open_modal() {
    
    document.getElementById('modal_backdrop').style.display = 'block';
    document.getElementById('order_modal').style.display = 'block';
    document.getElementById('order_modal').classList.add('show');
    document.querySelector('body').style.overflow = 'hidden';
}

close_modal() {
    document.getElementById('modal_backdrop').style.display = 'none';
    document.getElementById('order_modal').style.display = 'none';
    document.getElementById('order_modal').classList.remove('show');

    document.getElementById("preview").style.display = "none";
    document.querySelector('body').style.overflow = 'visible';
}

reset_input() {
    document.getElementById('order_form').reset();
    document.getElementById('action_order').value = 'Edit';
    document.getElementById('modal_title').innerHTML = 'Edit Data';
    document.getElementById('action_order_button').innerHTML = 'Edit';
    document.getElementById('show_order_image').src = "";


}


/* displays or removes error messages */
show_error(error, element) {
    console.log(element.replace('_error',''));
    error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
    if(error) {

      document.getElementById(element.replace('_error','')).style.border = "red solid 1px"; 

    }else {
      
       document.getElementById(element.replace('_error','')).style.border = "none";
      }    
}

/* scroll to the position of the input field with an error */
scroll_to(element) {
    console.log(element);
    if(element == "top") {
    document.getElementById("order_modal").scrollTo({
        top:0,
        left:0,
        behavior:"smooth"
    });
} else {
    document.getElementById("order_modal").scrollTo({
        top:(document.getElementById(element).offsetTop)-250,
        left:0,
        behavior:"smooth"
    });
}
}
}