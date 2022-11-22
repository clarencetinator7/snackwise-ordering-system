<?php



require_once dirname(__FILE__) . '/../classes/Dashboard.php';


$dashboard = new Dashboard(); 

$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$dashboard->display_dashboard($startdate,$enddate);



?>