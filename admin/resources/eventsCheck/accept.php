<?php

require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';


$id = $_GET['id'];

$id = Sanitize($id, 1);

$message = '';

if (!Validator($id, 3)) {

    $message = "Invalid id";
} else {

    //event_check
    $sqlchecks = "select * from events_check where id = $id";
    $opchecks =  mysqli_query($con, $sqlchecks);
    $dataCheck = mysqli_fetch_assoc($opchecks);


    $eventName = $dataCheck['event_name'];
    $eventdesc = $dataCheck['event_desc'];
    $eventdate = $dataCheck['e_date'];
    $eventlogo = $dataCheck['e_logo'];
    $eventadder = $dataCheck['event_submiter'];



    $sqlAddEvent = "insert into events (event_name,event_describtion,eventDate,event_logo,event_submiter) values ('$eventName','$eventdesc','$eventdate','$eventlogo',$eventadder)";
    $opAddEvent = mysqli_query($con, $sqlAddEvent);

    if ($opAddEvent) {

        $disOld  = '../../../assests/images/eventsCheckLogos/' . trim($eventlogo);
        $disFolder = '../../../assests/images/eventsLogos/' . trim($eventlogo);

        if (rename($disOld, $disFolder)) {

            $message = "Event Added";

            $sqldel = "delete from events_check where id =" . $id;
            $opdel = mysqli_query($con, $sqldel);
        }
    } else {
        $message = "Error Try Again !!!";
    }
}


$_SESSION['message'] = $message;

header("Location: " . resources('events/index.php'));
