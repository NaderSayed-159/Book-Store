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

    $sqlLogo = "select e_logo from events_check where id = " . $id;
    $opLogo  = mysqli_query($con, $sqlLogo);
    $dataLogo = mysqli_fetch_assoc($opLogo);

    if (!Validator('../../../assests/images/eventsCheckLogos/' . trim($dataLogo['e_logo']), 7)) {
        $message = "image is not deleted";
    }

    $sql = "delete from events_check where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "User Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
}


$_SESSION['message'] = $message;

header("Location: " . resources('eventsCheck/index.php'));
