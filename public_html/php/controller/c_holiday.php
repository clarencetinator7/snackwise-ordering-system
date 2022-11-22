<?php
require dirname(__FILE__) . '/../classes/Holiday.php';
require dirname(__FILE__) . '/../classes/Validate.php';



$holiday = new Holiday();
$validate = new Validate();
$holiday->delete_past_holiday();
if (isset($_POST["display_holiday"]) == 'display_holiday') {




    if (count($validate->output) > 0) {
        
        echo json_encode($validate->output);
    } else {
       
            /* $output['success'] = '<div class="alert alert-success">Vsss </div>';
            echo json_encode($output); */
            $holiday->display_holiday();
    }
}
if (isset($_POST["add_holiday"]) == 'add_holiday') {

$date = $_POST['date'];


    if (count($validate->output) > 0) {
        
        echo json_encode($validate->output);
    } else {
       
            /* $output['success'] = '<div class="alert alert-success">Vsss </div>';
            echo json_encode($output); */
            $holiday->add_holiday($date);
    }
}
if (isset($_POST["delete_holiday"]) == 'delete_holiday') {


    $holiday_id = $_POST['holiday_id'];

    if (count($validate->output) > 0) {
        
        echo json_encode($validate->output);
    } else {
       
            /* $output['success'] = '<div class="alert alert-success">Vsss </div>';
            echo json_encode($output); */
            $holiday->delete_holiday($holiday_id);
    }
}

