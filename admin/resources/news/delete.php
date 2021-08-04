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


    $sqlimg = "select image from news where id = " . $id;
    $opimg  = mysqli_query($con, $sqlimg);
    $dataimg = mysqli_fetch_assoc($opimg);


    if (!Validator('../../../assests/images/newsPics/' . trim($dataimg['image']), 7)) {

        $message = "image is not deleted";
    }




    $sql = "delete from news where id =" . $id;

    $op = mysqli_query($con, $sql);

    if ($op) {

        $message = "News Deleted .";
    } else {

        $message = "Error Try Again !!!";
    }
}


$_SESSION['message'] = $message;

header("Location: " . resources('news/index.php'));
