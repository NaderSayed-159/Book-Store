<?php

require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';

$id = $_GET['id'];

$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = '';

if (filter_var($id, FILTER_VALIDATE_INT)) {


    $sqlLogo = "select event_logo from events where id = " . $id;
    $opLogo  = mysqli_query($con, $sqlLogo);
    $dataLogo = mysqli_fetch_assoc($opLogo);

    if (file_exists('../../../assests/images/eventsLogos/' . $dataLogo['event_logo'])) {

        unlink('../../../assests/images/eventsLogos/' . $dataLogo['event_logo']);
    } else {
        $message = "image is not deleted";
    }
    $sql = "delete from events where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "User Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
} else {
    $message = "Invalid id";
}


$_SESSION['message'] = $message;

header("Location: " . resources('events/index.php'));
