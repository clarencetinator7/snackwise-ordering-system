class Notification {

  notification() {
    new Notification().notification_count();
    new Notification().display_notification();
  
  }

  /* hides or shows notifications */
  toggle_notification() {
    if (document.getElementById("notification_list").style.display == "none") {
      new Notification().display_notification();
      document.getElementById("notification_list").style.display = "block";
      console.log("block");
    } else {
      new Notification().update_notification();
      document.getElementById("notification_list").style.display = "none";
      console.log("none");
    }
  }

/* changes the status of notification from unread to read  */
  update_notification() {
    let form_data = new FormData();
    form_data.append('update_notification', 'update_notification');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      new Notification().notification_count();
    });
  }

  /*  count all the unread notification of a customer */
  notification_count() {
    /* document.getElementById("notification_list").style.display = "none"; */
    let form_data = new FormData();
    form_data.append('notification_count', 'notification_count');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      document.getElementById("notification_count").innerHTML = response_data.notification_count;
    });
  }

  /*  display all the notifications intended for the customer */
  display_notification() {
    let form_data = new FormData();
    form_data.append('display_notification', 'display_notification');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      let notification_list = "";
      console.log(response_data);
      if (response_data.data) {
        response_data.data.map(function (notif) {
          notification_list += `
              <div class="${notif.status} d-flex align-items-center" style="padding: 10px 10px; w-100">`;
          /* notification_list += `
              <div class="${notif.status} d-flex align-items-center" style="padding: 20px 20px; margin:10px; border-radius:10px;">`; */
             /*  if(notif.status == "read") {
                notification_list += `<div style="margin-bottom:-10px;"><i class="fa-solid fa-circle-check h2"></i></div>`;
              } else if(notif.status == "unread"){
                notification_list += `<div style="margin-bottom:-10px;"><i class="fa-solid fa-circle-exclamation h2"></i></div>`;
              } */
              notification_list += `<div style=" background-color:rgb(238,149,0); padding:6px 6px 0 6px; border-radius:15px;"><i class="fa-solid fa-circle-info h4" margin-bottom:-10px; style="color:white!important"></i></div>`;
              notification_list += ` <div style="margin-left:10px;font-size:14px;"> <div class=" fw-bold" >${notif.message}</div>
                <div class="" style="font-size:11px; margin-top:-5px;" >${notif.date}</div></div>
              </div>
              `;
              /* if(notif.status == "read") { */
                notification_list += `<hr class="p-0 my-0">`;
              /* } */
        });
      }
      document.getElementById("notification_list").innerHTML = notification_list;
/*       document.querySelector("#notification_list:first-child").style.padding = "110px!important";  */
    });
  }

  /* creates  and display a notification */
  create_notification(message, type) {
    let create_toast_notif_dialog = document.createElement("div");
    /* adds an id to the element which will be used to automatically remove it to the DOM after a specific time */
    let id = Math.random().toString(36).substr(2, 10);
    create_toast_notif_dialog.setAttribute("id", id);
    create_toast_notif_dialog.classList.add("toast_notif_dialog", type);
    create_toast_notif_dialog.innerText = message;
    document.getElementById("toast_notif").appendChild(create_toast_notif_dialog);

    let toast_notif_dialog = document.querySelector(".toast_notif").getElementsByClassName("toast_notif_dialog");
    let toast_notif_close = document.createElement("div");
    toast_notif_close.classList.add("toast_notif_close");
    toast_notif_close.innerHTML = '<i class="fas fa-times"></i>';
    create_toast_notif_dialog.appendChild(toast_notif_close);

    toast_notif_close.onclick = function (e) {
      create_toast_notif_dialog.remove();
    
    }
    setTimeout(() => {
      for (let i = 0; i < toast_notif_dialog.length; i++) {
        if (toast_notif_dialog[i].getAttribute("id") == id) {
          toast_notif_dialog[i].remove();
          break;
        }
      }
    }, 5000);
  }

/* -------------------- newsletter */
newsletter() {
  let form_data = new FormData(document.getElementById('newsletter_form'));
  form_data.append('newsletter', 'newsletter');
  return fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
  }).then(function (response) {
      return response.json();
  }).then(function (response_data) {
    console.log(response_data);
     if(response_data.success){
      new Notification().create_notification(response_data.success, "success");
      document.getElementById('newsletter_email').value = "";
     }  else if (response_data.newsletter_email_error) {
      new Notification().create_notification(response_data.newsletter_email_error, "error");
      document.getElementById("newsletter_email").focus();
    }  else if (response_data.error) {
     new Notification().create_notification(response_data.error, 'error');
     }
  });
}

/* -------------------- contact-us.php */
  send_email_message() {
    document.getElementById('submit').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    document.getElementById('submit').disabled = true;
    var form_data = new FormData(document.getElementById('contact_form'));
    form_data.append('send_email_message', 'send_email_message');
    return fetch('php/controller/c_notification.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      document.getElementById('submit').innerHTML = 'Submit';
      document.getElementById('submit').disabled = false;
       if(response_data.success){
        new Notification().create_notification(response_data.success, "success");
    document.getElementById('name').value = "";
    document.getElementById('email').value = "";
    document.getElementById('subject').value = "";
    document.getElementById('message').value = "";
       }  else if(response_data.error){
        new Notification().create_notification(response_data.error, "error");
       } 
      new Notification().show_error(response_data.name_error, 'name_error');
      new Notification().show_error(response_data.email_error, 'email_error');
      new Notification().show_error(response_data.subject_error, 'subject_error');
      new Notification().show_error(response_data.message_error, 'message_error');
  
    });
}

show_error(error, element) {
  console.log(element.replace('_error',''));
  error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
  error ? document.getElementById(element.replace('_error','')).style.border = "red solid 1px" : document.getElementById(element.replace('_error','')).style.border = "none";

}
}