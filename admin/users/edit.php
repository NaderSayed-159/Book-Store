<?php
ob_start();

require "../../helpers/paths.php";
require "../../helpers/functions.php";
require '../../helpers/dbConnection.php';
require '../../layout/navAdmin.php';
require '../../checklogin/checkLoginadmin.php';


$id = $_GET['id'];
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = "";

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = "Invalid Id";

    header("Location: " . users('index.php'));
}






$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $email = cleanInputs($_POST['email']);
    $phone = cleanInputs($_POST['phone']);
    $gender = Sanitize($_POST['gender'], 2);
    $usertype = Sanitize($_POST['usertype'], 1);




    //Name Validation
    if (!Validator($name, 1)) {
        $errorMessages['name'] = "Required";
    }

    if (!Validator($name, 2)) {

        $errorMessages['name'] = "Name Length must be more than 3 ";
    }


    //Email Validation
    if (!Validator($email, 1)) {
        $errorMessages['email'] = "Required";
    }

    if (!Validator($email, 4)) {
        $errorMessages['email'] = "Invalid Email";
    }






    // phone Validation ... 
    if (!Validator($phone, 1)) {
        $errorMessages['phone'] = "Required";
    }


    if (!Validator($phone, 2, 11)) {

        $errorMessages['phone'] = "Phone should be 11 numbers";
    }


    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        $sql22  = "update users set name = '$name' , email = '$email' , phone='$phone' , gender = '$gender' , user_type = '$usertype'  where id =$id ";

        $op   =  mysqli_query($con, $sql22);


        if ($op) {
            $_SESSION['message'] = "Data Updated";
            header("Location: " . users('index.php'));
        } else {
            $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
        }
    }
}



$sql = "select * from users where id = $id";
$op = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($op);





# Fetch dep Query .... 
$sqlTypes = "select * from usersTypes";
$op2 =  mysqli_query($con, $sqlTypes);






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo css('edit.css') ?>">
</head>

<body>

    <div class="container">
        <h2 class="text-center h1 text-danger m-5">Update Users Data </h2>
        <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50">
            <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo users('index.php') ?>">Users</a></li>
            <li class="breadcrumb-item active ">Edit User</li>
        </ol>

        <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger">
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
        <form action="edit.php?id=<?php echo $data['id']; ?>" method="POST" class="container mx-auto mt-5 d-flex flex-column  p-4 ps-0 " enctype="multipart/form-data">
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name" value="<?php echo $data['name']; ?>">
                    <label for="floatingInput">Enter Name</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input type="e-mail" class="form-control" id="floatingInput" placeholder="E-mail" name="email" value="<?php echo $data['email']; ?>">
                    <label for="floatingInput">E-mail</label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-around">
                <div class="col-lg-3 mt-3 mb-3 ">
                    <div class=" form-floating">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Phone.." name="phone" value="<?php echo $data['phone']; ?>">
                        <label for="floatingInput">Phone</label>
                    </div>
                </div>
                <div class="col-sm-3 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="usertype" class="p-2">Users Types</label>
                        <select name="usertype" id="usertype" class="form-select" name="usertype">
                            <?php while ($datas = mysqli_fetch_assoc($op2)) {
                            ?>
                                <option value="<?php echo $datas['id']; ?>" <?php if ($datas['id'] == $data['user_type']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $datas['user_type']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="gender" class="p-2">gender</label>
                        <select name="gender" id="gender" class="form-select" name="gender">
                            <option value="male" <?php if ($data['gender'] == 'male') {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                            <option value="female" <?php if ($data['gender'] == 'female') {
                                                        echo 'selected';
                                                    } ?>>Female</option>
                        </select>
                    </div>
                </div>
            </div>


            <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Update">

        </form>
    </div>

</body>

</html>