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
    $sqlimg = "select coverPic from books where id = " . $id;
    $opimg  = mysqli_query($con, $sqlimg);
    $dataimg = mysqli_fetch_assoc($opimg);


    if (file_exists('../../../assests/images/booksCovers/' . trim($dataimg['coverPic']))) {

        unlink('../../../assests/images/booksCovers/' . trim($dataimg['coverPic']));
    } else {
        $message = "image is not deleted";
    }

    $sql = "delete from books where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "User Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
}



$_SESSION['message'] = $message;

header("Location: index.php");
