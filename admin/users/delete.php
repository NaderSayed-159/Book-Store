<?php

require "../../helpers/paths.php";
require '../../helpers/dbConnection.php';
require "../../helpers/functions.php";
require '../../checklogin/checkLoginadmin.php';


$id = $_GET['id'];

$id = Sanitize($id, 1);

$message = '';

if (!Validator($id, 3)) {

    $message = "Invalid id";
} else {
    $sql = "delete from users where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "User Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
}


$_SESSION['message'] = $message;

header("Location: " . users('index.php'));
