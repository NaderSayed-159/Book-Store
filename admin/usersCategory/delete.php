<?php

require "../../helpers/paths.php";
require '../../helpers/dbConnection.php';
require '../../checklogin/checkLoginadmin.php';

$id = $_GET['id'];

$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = '';

if (filter_var($id, FILTER_VALIDATE_INT)) {

    $sql = "delete from userstypes where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "category Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
} else {
    $message = "Invalid id";
}


$_SESSION['message'] = $message;

header("Location: " . project('admin/usersCategory/index.php'));
