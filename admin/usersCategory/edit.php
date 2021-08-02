<?php
ob_start();
require "../../helpers/paths.php";
require "../../helpers/functions.php";
require '../../helpers/dbConnection.php';
require '../../checklogin/checkLoginadmin.php';
require '../../layout/navAdmin.php';

$errorMessages = [];

$id = $_GET['id'];
$id  = Sanitize($_GET['id'], 1);


if (!Validator($id, 3)) {
    $errorMessages['id'] = "Invalid ID";

    $_SESSION['message'] = $errorMessages;

    header("Location: " . project('admin/usersCategory/index.php'));
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category  = cleanInputs(Sanitize($_POST['Category'], 2));



    //event validation

    if (!Validator($category, 1)) {

        $errorMessages['Category'] = "Write Category";
    }
    if (!Validator($category, 2)) {

        $errorMessages['Category'] = " Category Name must be more than 3";
    }


    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        $sql = "update userstypes set user_type='$category' where id = " . $id;

        $ops =  mysqli_query($con, $sql);



        if ($ops) {

            $_SESSION['message'] = "Data updated";
            header("Location: " . project('admin/usersCategory/index.php'));
        } else {
            $errorMessages['Category'] = "Error in Your Sql Try Again";
        }


        $_SESSION['errmessages'] = $errorMessages;
    }
}


# Fetch Data to id . 
$sql  = "select * from userstypes where id = " . $id;
$op   = mysqli_query($con, $sql);
$FetchedData = mysqli_fetch_assoc($op);








?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding user Category </title>
    <link rel="stylesheet" href="<?php echo css('create.css') ?>">
</head>

<body class="col-12">

    <h1 class="text-danger">Add a new Category
        <small>Add Category </small>
    </h1>

    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo project('admin/usersCategory/index.php') ?>">Users Categories</a></li>
        <li class="breadcrumb-item active ">Edit User Category</li>
    </ol>

    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger text-center">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else {
            echo "Fill the inputs Please!";
        }
        ?>
    </h4>

    <form action="edit.php?id=<?php echo $FetchedData['id']; ?>" method="POST" class="  col-8 mx-auto mt-5 d-flex align-items-center flex-column  p-4 ps-0 " enctype="multipart/form-data">


        <div class="col-12 col-lg-7 m-3 mx-auto">
            <div class=" form-floating">
                <input value="<?php echo $FetchedData['user_type']; ?>" type="text" class="form-control" id="floatingInput" placeholder="Enter Category" name="Category">
                <label for="floatingInput">User Category</label>
            </div>
        </div>



        <input type="submit" class="btn btn-warning col-5 m-3 " value="Update">

    </form>


</body>

</html>