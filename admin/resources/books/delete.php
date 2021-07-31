<?php

require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';


$id = $_GET['id'];

$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = '';

if (filter_var($id, FILTER_VALIDATE_INT)) {

    $sqlimg = "select coverPic from books where id = " . $id;
    $opimg  = mysqli_query($con, $sqlimg);
    $dataimg = mysqli_fetch_assoc($opimg);


    if (file_exists('../../../assests/images/booksCovers/' . $dataimg['coverPic'])) {

        unlink('../../../assests/images/booksCovers/' . $dataimg['coverPic']);
    } else {
        $message = "image is not delete";
    }

    $sql = "delete from books where id =" . $id;

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

header("Location: index.php");
